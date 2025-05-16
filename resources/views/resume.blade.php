<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Resume</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />


    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10px;
            margin: 0;
            padding: 0;
            line-height: 1.2;
        }

        h1 {
            font-size: 16px;
            margin: 0;
        }

        h2 {
            font-size: 12px;
            margin-top: 10px;
            margin-bottom: 4px;
            border-bottom: 1px solid #ccc;
            padding-bottom: 2px;
        }

        .section {
            margin-bottom: 6px;
        }

        .info-label {
            font-weight: bold;
            display: inline-block;
            width: 100px;
        }

        ul {
            margin: 0 0 0 14px;
            padding: 0;
        }

        .sub {
            margin-bottom: 5px;
        }

        .certification-item {
            margin-bottom: 3px;
        }

        .job-title {
            font-weight: bold;
        }

        .job-company {
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="p-4">
        <!-- Personal Information -->
        @php
            $personalLines = explode("\n", $resume['personal_info'] ?? '');
        @endphp
        <div class="section">
            <h2>Personal Information</h2>
            @foreach($personalLines as $line)
                @php
                    [$label, $value] = explode(':', $line . ':', 2); // fallback : to avoid errors
                @endphp
                <div><strong>{{ trim($label) }}:</strong> {{ trim($value) }}</div>
            @endforeach
        </div>


        <!-- Profile Summary -->
        <div class="section">
            <h2>Profile Summary</h2>
            <p>{!! nl2br(e($resume['summary'] ?? '')) !!}</p>
        </div>

        <!-- Education -->
        <div class="section">
            <h2>Education</h2>
            @foreach(explode("\n\n", $resume['education'] ?? '') as $edu)
                @php
                    $lines = explode("\n", $edu);
                @endphp
                <div class="sub">
                    <p class="job-title">{{ $lines[0] ?? '' }}</p>
                    <p class="job-company">{{ $lines[1] ?? '' }}</p>
                    <p>{{ $lines[2] ?? '' }}</p>
                </div>
            @endforeach
        </div>


        @php
            $rawExperience = $resume['experience'] ?? '';
            $normalizedExperience = str_replace(["\r\n", "\r"], "\n", $rawExperience); // Normalize newlines
            $experiences = explode("\n\n", $normalizedExperience); // Now safe to split
        @endphp

        <div class="section">
            <h2>Work Experience</h2>

            @foreach($experiences as $exp)
                @php
                    $lines = explode("\n", trim($exp));
                    $title = $lines[0] ?? '';
                    $company = $lines[1] ?? '';
                    $dates = $lines[2] ?? '';
                    $bullets = array_slice($lines, 3);
                @endphp
                <div class="sub">
                    <div style="display: flex; justify-content: space-between;">
                        <span class="job-title">{{ $title }}</span>
                        <span class="job-company">{{ $company }} ({{ $dates }})</span>
                    </div>
                    <ul>
                        @foreach($bullets as $item)
                            @if(trim($item) !== '')
                                <li>{{ ltrim($item, "- ") }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>



        <!-- Skills -->
        <div class="section">
            <h2>Skills</h2>
            <ul>
                @foreach(explode("\n", $resume['skills'] ?? '') as $skill)
                    @if(!empty(trim($skill)))
                        <li>{{ ltrim($skill, "- ") }}</li>
                    @endif
                @endforeach
            </ul>
        </div>


        <!-- Certifications -->
        <div class="section">
            <h2>Certifications</h2>
            <ul>
                @foreach(explode("\n", $resume['certifications'] ?? '') as $cert)
                    @if(!empty(trim($cert)))
                        <li>{{ ltrim($cert, "- ") }}</li>
                    @endif
                @endforeach
            </ul>
        </div>

    </div>
    </div>
</body>

</html>