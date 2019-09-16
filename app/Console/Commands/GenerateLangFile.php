<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateLangFile extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'lang:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate MoniCAG language files';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            // Check available languages
            $availableLanguages = array_map('basename', glob('resources/lang/*', GLOB_ONLYDIR));

            // Generate the lang files contents
            $contents = [];
            foreach ($availableLanguages as $lang) $contents[$lang] = $this->generateLangFileContent($lang);

            // Store the lang files
            foreach ($contents as $lang => $content)
                Storage::disk('public')->put('lang/' . $lang . '.json', $content);

        } catch (Exception $err) {
            $this->error(__('messages.console.lang_generate.error'));
        }

        $this->info(__('messages.console.lang_generate.success'));
    }

    /**
     * Generate a language file content
     * @param $lang
     * @return string
     */
    private function generateLangFileContent($lang) {
        $files   = glob(resource_path('lang/' . $lang . '/*.php'));
        $strings = [];

        // Add locale_lang to file
        $strings['locale_lang'] = $lang;

        // Add content from PHP files
        foreach ($files as $file) {
            $name           = basename($file, '.php');
            $strings[$name] = require $file;
        }

        // Add content from json file
        $simpleWordsFileName = resource_path('lang/' . $lang . '.json');
        if (file_exists($simpleWordsFileName)) {
            $simpleWordsJson = json_decode(file_get_contents($simpleWordsFileName));
            foreach ($simpleWordsJson as $key => $value) {
                $strings[$key] = $value;
            }
        }

        return json_encode($strings);
    }
}
