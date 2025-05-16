<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResumeFormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;
use Throwable;
use Barryvdh\DomPDF\Facade\Pdf;
class CvController extends Controller
{
    public function generateCv(ResumeFormRequest $request)
    {
        $data = $request->validated();


        try {
            $prompt = $this->buildPromptFromUserData($data);
            $sections = $this->callGptForResume($prompt);

            return view('partials.edit_resume', ['sections' => $sections, 'regenarated_data' => $data]);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Generation failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function regenerateCv(Request $request)
    {
        try {
            $sections = $request->input('sections', []);
            $prompt = (string) $request->input("prompt", "");

            $prompt = $this->buildPromptFromSections($sections, $prompt);
            $parsedSections = $this->callGptForResume($prompt);

            return view('partials.edit_resume', [
                'sections' => $parsedSections,
                'regenarated_data' => $parsedSections
            ]);

        } catch (Throwable $e) {
            return response()->json([
                'error' => 'Regeneration failed',
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function GenerateResume(Request $request)
    {
        $resume = $request->input('sections');


        return Pdf::loadView('resume', ['resume' => $resume])
            ->setPaper('a4', 'portrait')
            ->download('resume.pdf');


    }

    private function callGptForResume(string $prompt): array
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . env('CHAT_GPT_KEY'),
        ])->post('https://api.openai.com/v1/chat/completions', [
                    'model' => 'gpt-4o-mini',
                    'messages' => [
                        ['role' => 'user', 'content' => $prompt]
                    ],
                    'temperature' => 0.7,
                    'max_tokens' => 1000
                ]);

        if ($response->failed()) {
            throw new \Exception('API request failed: ' . json_encode($response->json()));
        }

        $responseData = $response->json();

        if (!isset($responseData['choices'][0]['message']['content'])) {
            throw new \Exception('Invalid API response format');
        }

        return $this->parseSections($responseData['choices'][0]['message']['content']);
    }


    private function parseSections(string $text): array
    {
        $text = preg_replace('/^```[\s\S]*?\n|\n```$/', '', trim($text));
        $text = str_replace("\r", '', $text);
        $text = preg_replace('/^#+\s*/m', '', $text);
        $text = preg_replace('/\*\*(.*?)\*\*/', '$1', $text);

        $sections = [
            'personal_info' => '',
            'summary' => '',
            'education' => '',
            'experience' => '',
            'skills' => '',
            'certifications' => ''
        ];

        preg_match_all('/^(Personal Info|Summary|Education|Experience|Skills|Certifications)\s*\n(.*?)(?=^Personal Info|^Summary|^Education|^Experience|^Skills|^Certifications|\z)/ms', $text, $matches, PREG_SET_ORDER);

        foreach ($matches as $match) {
            $title = strtolower(str_replace(' ', '_', $match[1]));
            $content = trim($match[2]);
            $sections[$title] = $content;
        }

        return $sections;
    }




    private function buildPromptFromUserData(array $data): string
    {
        $prompt = <<<EOD
    You are a professional resume writer and career expert.
    Generate a polished, human-sounding, and ATS-optimized resume in markdown format using only the following user-provided data.

    Structure it like this:


    ## Personal Info
    provide personal in fo data like full_name ,email, phone ,address
    ## Summary
    Provide a strong, personalized professional summary.

    ## Education
    List each degree with institution and years.

    ## Experience
    For each role, show:
    - Job Title
    - Company
    - Start - End Date
    - 2-3 bullet points describing key responsibilities and accomplishments

    ## Skills
    Use bullet points.

    ## Certifications
    Include name and provider.

    Only use the following data:
    EOD;

        $prompt .= "\n\nPersonal Information:";
        foreach (['full_name', 'email', 'phone', 'address'] as $field) {
            if (!empty($data[$field])) {
                $prompt .= "\n- " . ucfirst(str_replace('_', ' ', $field)) . ": {$data[$field]}";
            }
        }


        // Education
        if (!empty($data['institution'])) {
            $prompt .= "\n\n### Education information:";
            foreach ($data['institution'] as $i => $institution) {
                $degree = $data['degree'][$i] ?? 'N/A';
                $start = $data['start_date'][$i] ?? '';
                $end = $data['end_date'][$i] ?? '';
                $prompt .= "\n- {$degree} at {$institution} ({$start} - {$end})";
            }
        }

        // Experience
        if (!empty($data['position'])) {
            $prompt .= "\n\n### Experience:";
            foreach ($data['position'] as $i => $position) {
                $company = $data['company'][$i] ?? '';
                $start = $data['start_date_exp'][$i] ?? '';
                $end = $data['end_date_exp'][$i] ?? '';
                $desc = $data['description'][$i] ?? '';
                $prompt .= "\n- {$position} at {$company} ({$start} - {$end})\n  - {$desc}";
            }
        }

        // Skills
        if (!empty($data['skills'])) {
            $prompt .= "\n\n### Skills:";
            foreach ($data['skills'] as $skill) {
                $prompt .= "\n- {$skill}";
            }
        }

        // Certifications
        if (!empty($data['certifications'])) {
            $prompt .= "\n\n### Certifications:";
            foreach ($data['certifications'] as $cert) {
                $prompt .= "\n- {$cert}";
            }
        }


        return $prompt;
    }


    private function buildPromptFromSections(array $sections, string $customPrompt = ''): string
    {
        $prompt = <<<EOD
    You are a professional resume writer and career expert.

    Regenerate a clean, polished, human-sounding, and ATS-optimized resume using the following data.

    Provide output in markdown format with these sections:

    ##Personal Info
    ## Summary
    ## Education
    ## Experience
    ## Skills
    ## Certifications

    Use only the content below:
    EOD;

        foreach ($sections as $section => $content) {
            $title = ucfirst($section);
            $prompt .= "\n\n## {$title}:\n{$content}";
        }

        // Append additional custom instructions if provided
        if (!empty(trim($customPrompt))) {
            $prompt .= "\n\nAdditional Instructions:\n" . trim($customPrompt);
        }

        return $prompt;
    }



}
