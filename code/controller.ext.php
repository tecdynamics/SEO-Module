<?php

class module_controller extends ctrl_module
{



    static $contents;
    static $encoding = 'UTF-8';
    static $keywords;
    static $wordLengthMin = 5;  
    static $wordOccuredMin = 2; 
    static $word2WordPhraseLengthMin = 3; 
    static $phrase2WordLengthMinOccur = 2; 
    static $word3WordPhraseLengthMin = 3; 
    static $phrase2WordLengthMin = 10; 
    static $phrase3WordLengthMinOccur = 2; 
    static $phrase3WordLengthMin = 10; 

    static function doautoceo ()
    {
        global $controller;
        if (!fs_director::CheckForEmptyValue($controller->GetControllerRequest('FORM',
                                                                               'data'))) {
            $params = $controller->GetControllerRequest('FORM', 'data');
            mb_internal_encoding(self::$encoding);
            self::$contents = self::replace_chars($params);
        }
    }



    static function getKeywords ()
    {
        $keywords = self::Parsewords() . self::Parse2words() . self::Parse3words();
         return !empty($keywords) ? htmlspecialchars('<meta name="Keywords" content="' . substr($keywords, 0, -2) . '"/>') : '';
    }



    static function replace_chars ($content)
    {
        $content = mb_strtolower($content);
        //$content = mb_strtolower($content, "UTF-8");
        $content = strip_tags($content);

        $punctuations = array(
            ',',
            ')',
            '(',
            '.',
            "'",
            '"',
            '<',
            '>',
            '!',
            '?',
            '/',
            '-',
            '_',
            '[',
            ']',
            ':',
            '+',
            '=',
            '#',
            '$',
            '&quot;',
            '&copy;',
            '&gt;',
            '&lt;',
            '&nbsp;',
            '&trade;',
            '&reg;',
            ';',
            chr(10),
            chr(13),
            chr(9));

        $content = str_replace($punctuations, " ", $content);
        $content = preg_replace('/ {2,}/si', " ", $content);

        return $content;
    }



    static function getParse_words ()
    {
        $retData = self::Parsewords();
        return !empty($retData) ? htmlspecialchars('<meta name="Keywords" content="' . substr($retData, 0, -2) . '"/>') : '';
    }



    static function getParse_2words ()
    {
        $retData = self::Parse2words();
        return !empty($retData) ? htmlspecialchars('<meta name="Keywords" content="' . substr($retData, 0, -2). '"/>') : '';
    }



    static function getParse_3words ()
    {
        $retData = self::Parse3words();
        return !empty($retData) ? htmlspecialchars('<meta name="Keywords" content="' . substr($retData, 0, -2) . '"/>') : '';
    }



    static function Parsewords ()
    {
        $common = array(
            "able",
            "about",
            "above",
            "act",
            "add",
            "afraid",
            "after",
            "again",
            "against",
            "age",
            "ago",
            "agree",
            "all",
            "almost",
            "alone",
            "along",
            "already",
            "also",
            "although",
            "always",
            "am",
            "amount",
            "an",
            "and",
            "anger",
            "angry",
            "animal",
            "another",
            "answer",
            "any",
            "appear",
            "apple",
            "are",
            "arrive",
            "arm",
            "arms",
            "around",
            "arrive",
            "as",
            "ask",
            "at",
            "attempt",
            "aunt",
            "away",
            "back",
            "bad",
            "bag",
            "bay",
            "be",
            "became",
            "because",
            "become",
            "been",
            "before",
            "began",
            "begin",
            "behind",
            "being",
            "bell",
            "belong",
            "below",
            "beside",
            "best",
            "better",
            "between",
            "beyond",
            "big",
            "body",
            "bone",
            "born",
            "borrow",
            "both",
            "bottom",
            "box",
            "boy",
            "break",
            "bring",
            "brought",
            "bug",
            "built",
            "busy",
            "but",
            "buy",
            "by",
            "call",
            "came",
            "can",
            "cause",
            "choose",
            "close",
            "close",
            "consider",
            "come",
            "consider",
            "considerable",
            "contain",
            "continue",
            "could",
            "cry",
            "cut",
            "dare",
            "dark",
            "deal",
            "dear",
            "decide",
            "deep",
            "did",
            "die",
            "do",
            "does",
            "dog",
            "done",
            "doubt",
            "down",
            "during",
            "each",
            "ear",
            "early",
            "eat",
            "effort",
            "either",
            "else",
            "end",
            "enjoy",
            "enough",
            "enter",
            "even",
            "ever",
            "every",
            "except",
            "expect",
            "explain",
            "fail",
            "fall",
            "far",
            "fat",
            "favor",
            "fear",
            "feel",
            "feet",
            "fell",
            "felt",
            "few",
            "fill",
            "find",
            "fit",
            "fly",
            "follow",
            "for",
            "forever",
            "forget",
            "from",
            "front",
            "gave",
            "get",
            "gives",
            "goes",
            "gone",
            "good",
            "got",
            "gray",
            "great",
            "green",
            "grew",
            "grow",
            "guess",
            "had",
            "half",
            "hang",
            "happen",
            "has",
            "hat",
            "have",
            "he",
            "hear",
            "heard",
            "held",
            "hello",
            "help",
            "her",
            "here",
            "hers",
            "high",
            "hill",
            "him",
            "his",
            "hit",
            "hold",
            "hot",
            "how",
            "however",
            "I",
            "if",
            "ill",
            "in",
            "indeed",
            "instead",
            "into",
            "iron",
            "is",
            "it",
            "its",
            "just",
            "keep",
            "kept",
            "knew",
            "know",
            "known",
            "late",
            "least",
            "led",
            "left",
            "lend",
            "less",
            "let",
            "like",
            "likely",
            "likr",
            "lone",
            "long",
            "look",
            "lot",
            "make",
            "many",
            "may",
            "me",
            "mean",
            "met",
            "might",
            "mile",
            "mine",
            "moon",
            "more",
            "most",
            "move",
            "much",
            "must",
            "my",
            "near",
            "nearly",
            "necessary",
            "neither",
            "never",
            "next",
            "no",
            "none",
            "nor",
            "not",
            "note",
            "nothing",
            "now",
            "number",
            "of",
            "off",
            "often",
            "oh",
            "on",
            "once",
            "only",
            "or",
            "other",
            "ought",
            "our",
            "out",
            "please",
            "prepare",
            "probable",
            "pull",
            "pure",
            "push",
            "put",
            "raise",
            "ran",
            "rather",
            "reach",
            "realize",
            "reply",
            "require",
            "rest",
            "run",
            "said",
            "same",
            "sat",
            "saw",
            "say",
            "see",
            "seem",
            "seen",
            "self",
            "sell",
            "sent",
            "separate",
            "set",
            "shall",
            "she",
            "should",
            "side",
            "sign",
            "since",
            "so",
            "sold",
            "some",
            "soon",
            "sorry",
            "stay",
            "step",
            "stick",
            "still",
            "stood",
            "such",
            "sudden",
            "suppose",
            "take",
            "taken",
            "talk",
            "tall",
            "tell",
            "ten",
            "than",
            "thank",
            "that",
            "the",
            "their",
            "them",
            "then",
            "there",
            "therefore",
            "these",
            "they",
            "this",
            "those",
            "though",
            "through",
            "till",
            "to",
            "today",
            "told",
            "tomorrow",
            "too",
            "took",
            "tore",
            "tought",
            "toward",
            "tried",
            "tries",
            "trust",
            "try",
            "turn",
            "two",
            "under",
            "until",
            "up",
            "upon",
            "us",
            "use",
            "usual",
            "various",
            "verb",
            "very",
            "visit",
            "want",
            "was",
            "we",
            "well",
            "went",
            "were",
            "what",
            "when",
            "where",
            "whether",
            "which",
            "while",
            "white",
            "who",
            "whom",
            "whose",
            "why",
            "will",
            "with",
            "within",
            "without",
            "would",
            "yes",
            "yet",
            "you",
            "young",
            "your",
            "br",
            "img",
            "p",
            "lt",
            "gt",
            "quot",
            "copy");
        if (!empty(self::$contents)) {
            $s = @explode(" ", self::$contents);
            $k = array();
            foreach ($s as $key => $val) {
                if (mb_strlen(trim($val)) >= module_controller::$wordLengthMin &&
                          !in_array(trim($val), $common) && !is_numeric(trim($val))) {
                    $k[] = trim($val);
                }
                }
            $k = array_count_values($k);
            $occur_filtered = module_controller::occure_filter($k,
                                                               module_controller::$wordOccuredMin);
            @arsort($occur_filtered);

            $imploded = module_controller::implode(", ", $occur_filtered);
            unset($k);
            unset($s);
        }
        return $imploded;
    }

    static function Parse2words ()
    {
        $x = @explode(" ", module_controller::$contents);
        for ($i = 0; $i < count($x) - 1; $i++) {
            if ((mb_strlen(trim($x[$i])) >= module_controller::$word2WordPhraseLengthMin ) &&
                      (mb_strlen(trim($x[$i + 1])) >= module_controller::$word2WordPhraseLengthMin)) {
                $y[] = trim($x[$i]) . " " . trim($x[$i + 1]);
            }
                }

        $y = @array_count_values($y);

        $occur_filtered = module_controller::occure_filter($y,
                                                           module_controller::$phrase2WordLengthMinOccur);
        @arsort($occur_filtered);

        $imploded = module_controller::implode(", ", $occur_filtered);
        unset($y);
        unset($x);

        return $imploded;
    }

    static function Parse3words ()
    {
        $a = @explode(" ", self::$contents);
        $b = array();

        for ($i = 0; $i < count($a) - 2; $i++) {
            if ((mb_strlen(trim($a[$i])) >= module_controller::$word3WordPhraseLengthMin) &&
                      (mb_strlen(trim($a[$i + 1])) > module_controller::$word3WordPhraseLengthMin) &&
                      (mb_strlen(trim($a[$i + 2])) > module_controller::$word3WordPhraseLengthMin) &&
                      (mb_strlen(trim($a[$i]) . trim($a[$i + 1]) . trim($a[$i + 2])) > module_controller::$phrase3WordLengthMin)) {
                $b[] = trim($a[$i]) . " " . trim($a[$i + 1]) . " " . trim($a[$i +
                                    2]);
            }
                }
        $b = @array_count_values($b);
        $occur_filtered = self::occure_filter($b, module_controller::$phrase3WordLengthMinOccur);
        @arsort($occur_filtered);

        $imploded = self::implode(", ", $occur_filtered);
        unset($a);
        unset($b); 
        return $imploded;
    }



    static function occure_filter ($array_count_values, $min_occur)
    {
        $occur_filtered = array();
        if (\is_array($array_count_values)) {
            foreach ($array_count_values as $word => $occured) {
                if ($occured >= $min_occur) {
                    $occur_filtered[$word] = $occured;
                }
                }
        }

        return $occur_filtered;
    }



    static function implode ($gule, $array)
    {
        $c = "";
        foreach ($array as $key => $val) {
            @$c .= $key . $gule;
                }
        return $c;
    }





}


?>
