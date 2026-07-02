<?php

namespace Azuriom\Plugin\SeoLite\Helpers;

class ReadabilityHelper
{
    /**
     * Calculate Flesch readability score with multilingual support
     *
     * @param string $text The text to analyze
     * @return array Array containing score, level, message, language, and details
     */
    public static function calculateFleschScore($text)
    {
        // Check if text is empty
        if (!$text || trim($text) === '') {
            return [
                'total' => 0,
                'score' => 0,
                'level' => trans('seolite::messages.empty_text'),
                'message' => trans('seolite::messages.no_content'),
                'language' => 'unknown',
                'details' => [
                    'mots' => 0,
                    'syllabes' => 0,
                    'phrases' => 0,
                    'syllabesParMot' => 0,
                    'motsParPhrase' => 0
                ]
            ];
        }

        // Detect language based on character frequency and patterns
        $language = self::detectLanguage($text);

        // Count words - works for all languages with space-separated words
        $words = preg_split('/\s+/', trim($text), -1, PREG_SPLIT_NO_EMPTY);
        $nbWords = count($words);

        // Count sentences - universal sentence endings
        $phrases = preg_split('/[.!?]+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        $phrases = array_filter($phrases, function($phrase) {
            return trim($phrase) !== '';
        });
        $nbPhrases = max(1, count($phrases)); // Avoid division by zero

        // Count syllables - simplified universal approach
        $nbSyllabes = self::countSyllables($words, $language);

        // Calculate Flesch score using language-specific formulas
        $score = self::calculateScoreByLanguage($nbWords, $nbPhrases, $nbSyllabes, $language);

        // Determine difficulty level - language neutral descriptions
        $levelData = self::getDifficultyLevel($score);

        return [
            'score' => (float) $score,
            'level' => $levelData['level'],
            'message' => $levelData['message'],
            'language' => $language,
            'details' => [
                'mots' => $nbWords,
                'syllabes' => $nbSyllabes,
                'phrases' => $nbPhrases,
                'syllabesParMot' => $nbWords > 0 ? round($nbSyllabes / $nbWords, 2) : 0,
                'motsParPhrase' => round($nbWords / $nbPhrases, 2)
            ]
        ];
    }

    /**
     * Detect language based on character patterns
     *
     * @param string $text
     * @return string
     */
    private static function detectLanguage($text)
    {
        // Sample of text for analysis (up to 1000 chars)
        $sample = strtolower(substr($text, 0, 1000));

        // Language detection patterns
        $patterns = [
            'french' => '/[àáâæçèéêëîïôœùûüÿ]/i',
            'german' => '/[äöüßẞ]/i',
            'spanish' => '/[áéíóúüñ¿¡]/i',
            'italian' => '/[àèéìíîòóùú]/i',
            'portuguese' => '/[áàâãçéêíóôõú]/i',
            'russian' => '/[а-яА-ЯёЁ]/i',
            'japanese' => '/[\u3040-\u30ff\u3400-\u4dbf\u4e00-\u9fff]/i',
            'chinese' => '/[\u4e00-\u9fff\u3400-\u4dbf]/i',
            'korean' => '/[\uAC00-\uD7AF\u1100-\u11FF\u3130-\u318F\uA960-\uA97F\uD7B0-\uD7FF]/i',
            'arabic' => '/[\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFF]/i',
            'hebrew' => '/[\u0590-\u05FF\uFB1D-\uFB4F]/i'
        ];

        // Check for specific language patterns
        foreach ($patterns as $lang => $pattern) {
            if (preg_match($pattern, $sample)) {
                return $lang;
            }
        }

        // Default to English if no specific patterns are found
        return 'english';
    }

    /**
     * Count syllables in words using universal approach
     *
     * @param array $words
     * @param string $language
     * @return int
     */
    private static function countSyllables($words, $language)
    {
        $nbSyllabes = 0;

        foreach ($words as $word) {
            // Convert to lowercase and remove punctuation - works for all languages
            $word = preg_replace('/[^\p{L}\p{N}]/u', '', strtolower($word));

            if (strlen($word) === 0) continue;

            // Universal syllable counting approach
            $syllabes = 0;

            // Count vowel groups (works for most languages including Cyrillic, Latin scripts)
            // This pattern includes common vowels from multiple languages
            $vowelPattern = '/[aeiouàáâãäåæèéêëìíîïòóôõöøùúûüýÿāēīōūăĕĭŏŭąęįųćńśźłđšžčřťďňĺľŕґєіїўыэюяёаеиоуэюяыъьѐѝѓќѕјљњћџѣѥѧѩѫѭѯѱѳѵѷѹѻѽѿҁҋҍҏґғҕҗҙқҝҟҡңҥҧҩҫҭүұҳҵҷҹһҽҿӀӂӄӆӈӊӌӎӑӓӕӗәӛӝӟӡӣӥӧөӫӭӯӱӳӵӷӹӻӽӿԁԃԅԇԉԋԍԏԑԓԕԗԙԛԝԟԡԣԥԧԩԫԭԯ]/i';

            if (preg_match_all($vowelPattern, $word, $matches)) {
                // Count vowel groups, not individual vowels
                $vowelGroups = preg_split('/[^aeiouàáâãäåæèéêëìíîïòóôõöøùúûüýÿāēīōūăĕĭŏŭąęįųćńśźłđšžčřťďňĺľŕґєіїўыэюяёаеиоуэюяыъьѐѝѓќѕјљњћџѣѥѧѩѫѭѯѱѳѵѷѹѻѽѿҁҋҍҏґғҕҗҙқҝҟҡңҥҧҩҫҭүұҳҵҷҹһҽҿӀӂӄӆӈӊӌӎӑӓӕӗәӛӝӟӡӣӥӧөӫӭӯӱӳӵӷӹӻӽӿԁԃԅԇԉԋԍԏԑԓԕԗԙԛԝԟԡԣԥԧԩԫԭԯ]/i', $word, -1, PREG_SPLIT_NO_EMPTY);
                $syllabes = count(array_filter($vowelGroups, function($group) {
                    return preg_match('/[aeiouàáâãäåæèéêëìíîïòóôõöøùúûüýÿāēīōūăĕĭŏŭąęįųćńśźłđšžčřťďňĺľŕґєіїўыэюяёаеиоуэюяыъьѐѝѓќѕјљњћџѣѥѧѩѫѭѯѱѳѵѷѹѻѽѿҁҋҍҏґғҕҗҙқҝҟҡңҥҧҩҫҭүұҳҵҷҹһҽҿӀӂӄӆӈӊӌӎӑӓӕӗәӛӝӟӡӣӥӧөӫӭӯӱӳӵӷӹӻӽӿԁԃԅԇԉԋԍԏԑԓԕԗԙԛԝԟԡԣԥԧԩԫԭԯ]/i', $group);
                }));
            } else {
                // If no vowels found, assume at least one syllable
                $syllabes = 1;
            }

            // Minimum one syllable per word
            if ($syllabes === 0) $syllabes = 1;

            $nbSyllabes += $syllabes;
        }

        return $nbSyllabes;
    }

    /**
     * Calculate Flesch score using language-specific formulas
     *
     * @param int $nbWords
     * @param int $nbPhrases
     * @param int $nbSyllabes
     * @param string $language
     * @return float
     */
    private static function calculateScoreByLanguage($nbWords, $nbPhrases, $nbSyllabes, $language)
    {
        switch ($language) {
            case 'french':
                // French Flesch formula (adapted)
                $score = 207 - (1.015 * ($nbWords / $nbPhrases)) - (73.6 * ($nbSyllabes / $nbWords));
                break;

            case 'german':
                // German Flesch formula (adapted)
                $score = 180 - (1 * ($nbWords / $nbPhrases)) - (58.5 * ($nbSyllabes / $nbWords));
                break;

            case 'spanish':
            case 'italian':
            case 'portuguese':
                // Romance languages formula (adapted)
                $score = 206.835 - (1.02 * ($nbWords / $nbPhrases)) - (60 * ($nbSyllabes / $nbWords));
                break;

            case 'russian':
                // Cyrillic languages formula (adapted)
                $score = 206.835 - (1.3 * ($nbWords / $nbPhrases)) - (60.1 * ($nbSyllabes / $nbWords));
                break;

            default:
                // Standard English Flesch formula
                $score = 206.835 - (1.015 * ($nbWords / $nbPhrases)) - (84.6 * ($nbSyllabes / $nbWords));
        }

        return max(0, min(100, round($score, 1)));
    }

    /**
     * Get difficulty level and message based on score
     *
     * @param float $score
     * @return array
     */
    private static function getDifficultyLevel($score)
    {
        $prefix = trans('seolite::messages.readability_score') . ':';

        if ($score >= 80) {
            return [
                'level' => trans('seolite::messages.very_easy'),
                'message' => $prefix . ' ' . trans('seolite::messages.very_easy_text')
            ];
        } elseif ($score >= 60) {
            return [
                'level' => trans('seolite::messages.easy'),
                'message' => $prefix . ' ' . trans('seolite::messages.easy_text')
            ];
        } elseif ($score >= 40) {
            return [
                'level' => trans('seolite::messages.standard'),
                'message' => $prefix . ' ' . trans('seolite::messages.standard_text')
            ];
        } elseif ($score >= 20) {
            return [
                'level' => trans('seolite::messages.difficult'),
                'message' => $prefix . ' ' . trans('seolite::messages.difficult_text')
            ];
        } else {
            return [
                'level' => trans('seolite::messages.very_difficult'),
                'message' => $prefix . ' ' . trans('seolite::messages.very_difficult_text')
            ];
        }
    }

    /**
     * Calculate readability score for SEO scoring (20 points max)
     *
     * @param string $text
     * @return array
     */
    public static function calculateReadabilityScore($text)
    {
        $fleschData = self::calculateFleschScore($text);

        // Determine score based on Flesch readability thresholds (max 20 points)
        $total = 0;
        if ($fleschData['score'] >= 80) {
            $total = 20; // Very easy - perfect score
        } elseif ($fleschData['score'] >= 60) {
            $total = 18; // Easy - excellent score
        } elseif ($fleschData['score'] >= 40) {
            $total = 15; // Standard - good score
        } elseif ($fleschData['score'] >= 20) {
            $total = 10; // Difficult - moderate score
        } elseif ($fleschData['score'] > 0) {
            $total = 5; // Very difficult - low score
        } else {
            $total = 0; // No content
        }

        return [
            'total' => $total,
            'max' => 20,
            'flesch_data' => $fleschData
        ];
    }
}
