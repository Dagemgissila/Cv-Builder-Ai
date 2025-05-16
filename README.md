# Resume Generator with OpenAI GPT

This Laravel-based application allows users to generate polished, ATS-optimized resumes using OpenAI's GPT API. Users can fill out a form with their education, experience, skills, certifications, and personal information, and the system will generate a markdown-formatted resume, editable on the frontend, and exportable as PDF.

## Features

-   Generate resume using GPT (OpenAI)
-   Edit generated content before exporting
-   Export resume as PDF
-   Regenerate content using modified inputs

## Requirements

-   PHP >= 8.1
-   Composer
-   Laravel >= 12
-   OpenAI API Key
-   Internet connection

## Installation

### Step-by-step Setup

```bash
# Clone the repository
git clone https://github.com/Dagemgissila/Cv-Builder-Ai.git
cd Cv-Builder-Ai

# Install dependencies
composer install

# Copy environment file
cp .env.example .env

# Generate the application key
php artisan key:generate

```

### Set up your OpenAI API Key

### Open the .env file and add your API key:

CHAT_GPT_KEY=your_openai_api_key_here
