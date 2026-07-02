<?php

namespace Azuriom\Plugin\SeoLite\Helpers;

class SeoAnalysisHelper
{
    /**
     * Calculate SEO data for a post.
     *
     * @param object $post The post object
     * @return array SEO analysis data
     */
    public static function calculateSeoData($post)
    {
        $content = strip_tags($post->content ?? '');
        $title = $post->title ?? '';

        // Calculate text counter score (content length based)
        $contentLength = strlen($content);
        $textCounterScore = min(100, ($contentLength / 1000) * 100); // Max 100 for 1000+ chars

        // Calculate Flesch readability score
        $fleschScore = self::calculateFleschScore($content);

        // Calculate overall SEO score (simplified)
        $titleScore = self::calculateTitleScore($title);
        $contentScore = $contentLength > 300 ? 100 : ($contentLength / 300) * 100;

        $overallScore = ($titleScore + $contentScore + $fleschScore) / 3;

        return [
            'text_counter_score' => round($textCounterScore),
            'flesch_score' => round($fleschScore),
            'overall_score' => round($overallScore),
            'content_length' => $contentLength,
            'word_count' => str_word_count($content),
        ];
    }

    /**
     * Calculate Flesch readability score with language detection and proper syllable counting.
     *
     * @param string $text The text to analyze
     * @return float The Flesch readability score
     */
    public static function calculateFleschScore($text)
    {
        if (empty($text)) {
            return 0;
        }

        // Detect language from app locale or default to English
        $language = self::detectLanguage();

        // Count words
        $words = preg_split('/\s+/', trim($text));
        $nbWords = count($words);

        // Count sentences
        $sentences = preg_split('/[.!?]+/', $text);
        $sentences = array_filter($sentences, function($sentence) {
            return trim($sentence) !== '';
        });
        $nbPhrases = max(1, count($sentences));

        // Count syllables using improved method
        $nbSyllabes = 0;

        foreach ($words as $word) {
            $word = mb_strtolower(preg_replace('/[^\p{L}\p{N}]/u', '', $word));

            if (mb_strlen($word) === 0) continue;

            $syllabes = 0;

            // Vowel pattern that includes common vowels from multiple languages
            $vowelPattern = '/[aeiouàáâãäåæèéêëìíîïòóôõöøùúûüýÿāēīōūăĕĭŏŭąęįųćńśźłđšžčřťďňĺľŕґєіїўыэюяёаеиоуэюяыъьѐѝѓќѕјљњћџѣѥѧѩѫѭѯѱѳѵѷѹѻѽѿҁҋҍҏґғҕҗҙқҝҟҡңҥҧҩҫҭүұҳҵҷҹһҽҿӀӂӄӆӈӊӌӎӑӓӕӗәӛӝӟӡӣӥӧөӫӭӯӱӳӵӷӹӻӽӿԁԃԅԇԉԋԍԏԑԓԕԗԙԛԝԟԡԣԥԧԩԫԭԯ]/u';

            if (preg_match_all($vowelPattern, $word, $matches)) {
                // Count vowel groups instead of individual vowels
                $vowelString = preg_replace($vowelPattern, 'V', $word);
                preg_match_all('/V+/', $vowelString, $vowelGroups);
                $syllabes = count($vowelGroups[0]);
            } else {
                $syllabes = 1;
            }

            if ($syllabes === 0) $syllabes = 1;
            $nbSyllabes += $syllabes;
        }

        // Apply language-specific formulas
        switch ($language) {
            case 'fr':
                $score = 207 - (1.015 * ($nbWords / $nbPhrases)) - (73.6 * ($nbSyllabes / $nbWords));
                break;
            case 'de':
                $score = 180 - (1 * ($nbWords / $nbPhrases)) - (58.5 * ($nbSyllabes / $nbWords));
                break;
            case 'es':
            case 'it':
            case 'pt':
                $score = 206.835 - (1.02 * ($nbWords / $nbPhrases)) - (60 * ($nbSyllabes / $nbWords));
                break;
            case 'ru':
            case 'uk':
                $score = 206.835 - (1.3 * ($nbWords / $nbPhrases)) - (60.1 * ($nbSyllabes / $nbWords));
                break;
            default: // English and others
                $score = 206.835 - (1.015 * ($nbWords / $nbPhrases)) - (84.6 * ($nbSyllabes / $nbWords));
        }

        return max(0, min(100, $score));
    }

    /**
     * Detect language from app locale.
     *
     * @return string Language code
     */
    private static function detectLanguage()
    {
        $locale = app()->getLocale();
        $langCode = substr($locale, 0, 2);

        $supportedLanguages = ['fr', 'de', 'es', 'it', 'pt', 'ru', 'uk'];

        return in_array($langCode, $supportedLanguages) ? $langCode : 'en';
    }

    /**
     * Calculate title score based on length.
     *
     * @param string $title The title to analyze
     * @return int The title score
     */
    public static function calculateTitleScore($title)
    {
        $length = strlen($title);

        if ($length >= 50 && $length <= 60) {
            return 100; // Perfect
        } elseif ($length >= 30 && $length < 50) {
            return 80; // Good
        } elseif ($length > 60 && $length <= 80) {
            return 70; // Acceptable
        } else {
            return 30; // Poor
        }
    }
}
