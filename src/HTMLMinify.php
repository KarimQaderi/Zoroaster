<?php

    namespace KarimQaderi\Zoroaster;

    class HTMLMinify {

        const DOCTYPE_HTML4 = 'HTML4.01';
        const DOCTYPE_XHTML1 = 'XHTML1.0';
        const DOCTYPE_HTML5 = 'html5';
        const OPTIMIZATION_SIMPLE = 0;
        const OPTIMIZATION_ADVANCED = 1;
        /**
         * @var null|string
         */
        protected $html = null;
        /**
         * @var array
         */
        protected $options = array();
        /**
         * @var HtmlToken[] $tokens
         */
        protected $tokens;
        protected $tagDisplay = array(
            'a' => 'inline',
            'abbr' => 'inline',
            'acronym' => 'inline',
            'address' => 'block',
            'applet' => 'inline',
            'area' => 'none',
            'article' => 'block',
            'aside' => 'block',
            'audio' => 'inline',
            'b' => 'inline',
            'base' => 'inline',
            'basefont' => 'inline',
            'bdo' => 'inline',
            'bgsound' => 'inline',
            'big' => 'inline',
            'blockquote' => 'block',
            'body' => 'block',
            'br' => 'inline',
            'button' => 'inline-block',
            'canvas' => 'inline',
            'caption' => 'table-caption',
            'center' => 'block',
            'cite' => 'inline',
            'code' => 'inline',
            'col' => 'table-column',
            'colgroup' => 'table-column-group',
            'command' => 'inline',
            'datalist' => 'none',
            'dd' => 'block',
            'del' => 'inline',
            'details' => 'block',
            'dfn' => 'inline',
            'dir' => 'block',
            'div' => 'block',
            'dl' => 'block',
            'dt' => 'block',
            'em' => 'inline',
            'embed' => 'inline',
            'fieldset' => 'block',
            'figcaption' => 'block',
            'figure' => 'block',
            'font' => 'inline',
            'footer' => 'block',
            'form' => 'block',
            'frame' => 'block',
            'frameset' => 'block',
            'h1' => 'block',
            'h2' => 'block',
            'h3' => 'block',
            'h4' => 'block',
            'h5' => 'block',
            'h6' => 'block',
            'head' => 'none',
            'header' => 'block',
            'hgroup' => 'block',
            'hr' => 'block',
            'html' => 'block',
            'i' => 'inline',
            'iframe' => 'inline',
            'image' => 'inline',
            'img' => 'inline',
            'input' => 'inline-block',
            'ins' => 'inline',
            'isindex' => 'inline-block',
            'kbd' => 'inline',
            'keygen' => 'inline-block',
            'label' => 'inline',
            'layer' => 'block',
            'legend' => 'block',
            'li' => 'list-item',
            'link' => 'none',
            'listing' => 'block',
            'map' => 'inline',
            'mark' => 'inline',
            'marquee' => 'inline-block',
            'menu' => 'block',
            'meta' => 'none',
            'meter' => 'inline-block',
            'nav' => 'block',
            'nobr' => 'inline',
            'noembed' => 'inline',
            'noframes' => 'none',
            'nolayer' => 'inline',
            'noscript' => 'inline',
            'object' => 'inline',
            'ol' => 'block',
            'optgroup' => 'inline',
            'option' => 'inline',
            'output' => 'inline',
            'p' => 'block',
            'param' => 'none',
            'plaintext' => 'block',
            'pre' => 'block',
            'progress' => 'inline-block',
            'q' => 'inline',
            'rp' => 'inline',
            'rt' => 'inline',
            'ruby' => 'inline',
            's' => 'inline',
            'samp' => 'inline',
            'script' => 'none',
            'section' => 'block',
            'select' => 'inline-block',
            'small' => 'inline',
            'source' => 'inline',
            'span' => 'inline',
            'strike' => 'inline',
            'strong' => 'inline',
            'style' => 'none',
            'sub' => 'inline',
            'summary' => 'block',
            'sup' => 'inline',
            'table' => 'table',
            'tbody' => 'table-row-group',
            'td' => 'table-cell',
            'textarea' => 'inline-block',
            'tfoot' => 'table-footer-group',
            'th' => 'table-cell',
            'thead' => 'table-header-group',
            'title' => 'none',
            'tr' => 'table-row',
            'track' => 'inline',
            'tt' => 'inline',
            'u' => 'inline',
            'ul' => 'inline-block',
            'var' => 'inline',
            'video' => 'inline',
            'wbr' => 'inline',
            'xmp' => 'block',
        );
        protected $emptyTag = array(
            'area' => 'area',
            'base' => 'base',
            'basefont' => 'basefont',
            'br' => 'br',
            'col' => 'col',
            'embed' => 'embed',
            'frame' => 'frame',
            'hr' => 'hr',
            'img' => 'img',
            'input' => 'input',
            'isindex' => 'isindex',
            'link' => 'link',
            'meta' => 'meta',
            'param' => 'param',
        );
        /**
         * @param string $html
         * @param array $options
         */
        public function __construct($html, $options = array()) {
            $html = ltrim($html);
            $this->html = $html;
            $this->options = $this->options($options);
            $SegmentedString = new SegmentedString($html);
            $HTMLTokenizer = new HTMLTokenizer($SegmentedString, $options);
            $this->tokens = $HTMLTokenizer->tokenizer();
        }
        /**
         * 'optimizationLevel'
         *     OPTIMIZATION_SIMPLE(default)
         *         : replace many whitespace to a single whitespace
         *           this option leave a new line of one
         *     OPTIMIZATION_ADVANCED
         *         : remove the white space of all as much as possible
         *
         * 'emptyElementAddSlash'
         *     HTML4.01  no slash  : <img src=""><br>
         *     XHTML1.0  add slash : <img src="" /><br />
         *     HTML5     mixed OK  : <img src=""><br />
         *
         *     example : <img src="">
         *     true(default) : <img src=""/>
         *     false         : <img src="">
         *
         * 'emptyElementAddWhitespaceBeforeSlash'
         *     HTML4.01  no slash  : <img src=""><br>
         *     XHTML1.0  add slash : <img src="" /><br />
         *     HTML5     mixed OK  : <img src=""><br />
         *
         *     example : <img src=""/>
         *     true(default) : <img src="" />
         *     false         : <img src=""/>
         *
         * 'removeComment'
         *     example : <!-- HTML --><!--[if expression]> HTML <![endif]--><![if expression]> HTML <![endif]>
         *     true(default) => <!--[if expression]> HTML <![endif]--><![if expression]> HTML <![endif]>
         *     false         => do nothing
         *
         * 'excludeComment'
         *     example : <!--nocache-->content</--nocache-->
         *     array('/<!--\/?nocache-->/')(default)             => content
         *     array('/<!--\/?nocache-->/') => <!--nocache-->content</--nocache-->
         *
         * 'removeDuplicateAttribute'
         *     example : <img src="first.png" src="second.png">
         *     true(default) => <img src="first.png">
         *     false         => do nothing
         *
         * @param array $options
         * @return array
         */
        protected function options(Array $options) {
            $_options = array(
                'doctype' => static::DOCTYPE_XHTML1,
                'optimizationLevel' => static::OPTIMIZATION_SIMPLE,
                'emptyElementAddSlash' => false,
                'emptyElementAddWhitespaceBeforeSlash' => false,
                'removeComment' => true,
                'excludeComment' => array(),
                'removeDuplicateAttribute' => true,
            );
            $documentTypeOptions = array(
                static::DOCTYPE_HTML4 => array(
                    'doctype' => static::DOCTYPE_HTML4,
                    'emptyElementAddSlash' => false,
                    'emptyElementAddWhitespaceBeforeSlash' => false,
                ),
                static::DOCTYPE_XHTML1 => array(
                    'doctype' => static::DOCTYPE_XHTML1,
                    'emptyElementAddSlash' => true,
                    'emptyElementAddWhitespaceBeforeSlash' => true,
                ),
                static::DOCTYPE_HTML5 => array(
                    'doctype' => static::DOCTYPE_HTML5,
                    'emptyElementAddSlash' => false,
                    'emptyElementAddWhitespaceBeforeSlash' => false,
                ),
            );
            $documentTypeOption = $documentTypeOptions[static::DOCTYPE_XHTML1];
            if (isset($options['doctype'])) {
                $doctype = $options['doctype'];
                if (isset($documentTypeOptions[$doctype])) {
                    $documentTypeOption = $documentTypeOptions[$doctype];
                }
            }
            return $options + $documentTypeOption + $_options;
        }
        /**
         * @param $html
         * @param array $options
         * @return string
         */
        public static function minify($html, $options = array()) {
            $instance = new self($html, $options);
            return $instance->process();
        }
        /**
         * @return HtmlToken[]
         */
        public function getTokens() {
            return $this->tokens;
        }
        /**
         * @return string
         */
        public function process() {
            $this->beforeFilter();
            $html = $this->_buildHtml($this->tokens);
            return $html;
        }
        /**
         * @param array $tokens
         * @return string
         */
        protected function _buildHtml(Array $tokens) {
            $html = '';
            foreach ($tokens as $token) {
                $html .= $this->_buildElement($token);
            }
            return $html;
        }
        protected function _buildElement(HTMLToken $token) {
            switch ($token->getType()) {
                case HTMLToken::DOCTYPE:
                    $html = $token->getHtmlOrigin();
                    break;
                case HTMLToken::StartTag:
                    $tagName = $token->getTagName();
                    $selfClosing = '';
                    if (isset($this->emptyTag[$tagName]) && $this->options['emptyElementAddSlash']) {
                        $selfClosing = '/';
                        $selfClosing = ($this->options['emptyElementAddWhitespaceBeforeSlash'] ? ' ' : '') . $selfClosing;
                    }
                    $attributes = $this->_buildAttributes($token);
                    $beforeAttributeSpace = '';
                    if ($attributes) {
                        $beforeAttributeSpace = ' ';
                    }
                    $html = sprintf('<%s%s%s%s>', $token->getTagName(), $beforeAttributeSpace, $attributes, $selfClosing);
                    break;
                case HTMLToken::EndTag:
                    $html = sprintf('</%s>', $token->getTagName());
                    break;
                default :
                    $html = $token->getData();
                    break;
            }
            return $html;
        }
        /**
         * @param HTMLToken $token
         * @return string
         */
        protected function _buildAttributes(HTMLToken $token) {
            $attr = array();
            $format = '%s=%s%s%s';
            foreach ($token->getAttributes() as $attribute) {
                $name = $attribute['name'];
                $value = $attribute['value'];
                switch ($attribute['quoted']) {
                    case HTMLToken::DoubleQuoted:
                        $quoted = '"';
                        break;
                    case HTMLToken::SingleQuoted:
                        $quoted = '\'';
                        break;
                    default:
                        $quoted = '';
                        break;
                }
                if ($quoted === '' && $value === '') {
                    $attr[] = $name;
                } else {
                    $attr[] = sprintf($format, $name, $quoted, $value, $quoted);
                }
            }
            return join(' ', $attr);
        }
        protected function beforeFilter() {
            if ($this->options['removeComment']) {
                $this->removeWhitespaceFromComment();
            }
            $this->removeWhitespaceFromCharacter();
            if ($this->options['removeDuplicateAttribute']) {
                $this->optimizeStartTagAttributes();
            }
        }
        protected function removeWhitespaceFromComment() {
            $tokens = $this->tokens;
            $regexps = $this->options['excludeComment'];
            $HTMLTokenStartTag = HTMLToken::StartTag;
            $HTMLTokenComment = HTMLToken::Comment;
            $HTMLTokenCharacter = HTMLToken::Character;
            $HTMLNamesScriptTag = HTMLNames::scriptTag;
            $HTMLNamesStyleTag = HTMLNames::styleTag;
            $removes = array();
            $combineIndex = null;
            $len = count($tokens);
            for ($i = 0; $i < $len; $i++) {
                $token = $tokens[$i];
                $type = $token->getType();
                if ($type === $HTMLTokenStartTag) {
                    $combineIndex = null;
                    $tagName = $token->getTagName();
                    if ($tagName === $HTMLNamesScriptTag || $tagName === $HTMLNamesStyleTag) {
                        $i++;
                    }
                    continue;
                } else if ($type === $HTMLTokenCharacter) {
                    if ($combineIndex > 0) {
                        $tokens[$combineIndex]->setData($tokens[$combineIndex] . $token);
                        $removes[] = $i;
                    }
                    continue;
                } else if ($type !== $HTMLTokenComment) {
                    $combineIndex = null;
                    continue;
                }
                $comment = $token->getData();
                if ($this->_isConditionalComment($comment)) {
                    $combineIndex = null;
                    continue;
                }
                if ($regexps) {
                    foreach ($regexps as $regexp) {
                        if (preg_match($regexp, $comment)) {
                            $combineIndex = null;
                            continue 2;
                        }
                    }
                }
                $combineIndex = $i - 1;
                $removes[] = $i;
            }
            foreach ($removes as $remove) {
                unset($tokens[$remove]);
            }
            if ($len !== count($tokens)) {
                $tokens = array_merge($tokens,array());
            }
            $this->tokens = $tokens;
            return true;
        }
        protected function isInlineTag($tag) {
            $tags = $this->tagDisplay;
            if (!isset($tags[$tag])) {
                return true;
            }
            return $tags[$tag] === 'inline';
        }
        protected function removeWhitespaceFromCharacter() {
            $tokens = $this->tokens;
            $isEditable = true;
            $isBeforeInline = false;
            $uneditableTag = null;
            $type = null;
            $token = null;
            $isOptimize = $this->options['optimizationLevel'] === static::OPTIMIZATION_ADVANCED;
            for ($i = 0, $len = count($tokens); $i < $len; $i++) {
                /**
                 * @var HTMLToken $tokenBefore
                 */
                $tokenBefore = $token;
                $token = $tokens[$i];
                $type = $token->getType();
                if ($type === HTMLToken::StartTag) {
                    $tagName = $token->getName();
                    $isBeforeInline = $this->isInlineTag($tagName);
                    switch ($tagName) {
                        case HTMLNames::scriptTag:
                        case HTMLNames::styleTag:
                        case HTMLNames::textareaTag:
                        case HTMLNames::preTag:
                            $isEditable = false;
                            $uneditableTag = $tagName;
                            continue 2;
                            break;
                        default:
                            break;
                    }
                } else if ($type === HTMLToken::EndTag) {
                    $tagName = $token->getName();
                    $isBeforeInline = $this->isInlineTag($tagName);
                    if (!$isEditable && $tagName === $uneditableTag) {
                        $uneditableTag = null;
                        $isEditable = true;
                        continue;
                    }
                }
                if ($type !== HTMLToken::Character) {
                    continue;
                }
                $characters = $token->getData();
                if ($isEditable) {
                    if ($isOptimize && $i < ($len - 1)) {
                        $afterToken = $tokens[$i + 1];
                        $afterType = $afterToken->getType();
                        if (!$tokenBefore) {
                            $tokenBefore = new HTMLToken();
                        }
                        $typeBefore = $tokenBefore->getType();
                        $isTagBefore = $typeBefore === HTMLToken::StartTag || $typeBefore === HTMLToken::EndTag;
                        $isAfterTag = $afterType === HTMLToken::StartTag || $afterType === HTMLToken::EndTag;
                        $isAfterInline = $isAfterTag ? $this->isInlineTag($afterToken->getTagName()) : false;
                        if (($i === 0 || $isTagBefore) && $isAfterTag && (!$isBeforeInline || !$isAfterInline)) {
                            $characters = trim($characters);
                        } else if (($i === 0 || !$isBeforeInline) && !$isAfterInline) {
                            $characters = trim($characters);
                        }
                    }
                    $characters = $this->_removeWhitespaceFromCharacter($characters);
                    if ($i === ($len - 1)) {
                        $characters = rtrim($characters);
                    }
                } else if ($isOptimize && ($uneditableTag === HTMLNames::scriptTag || $uneditableTag === HTMLNames::styleTag)) {
                    $characters = trim($characters);
                }
                $tokens[$i]->setData($characters);
            }
            $this->tokens = $tokens;
        }
        /**
         * @param string $characters
         * @return string
         */
        protected function _removeWhitespaceFromCharacter($characters) {
            $compactCharacters = '';
            $hasWhiteSpace = false;
            for ($i = 0, $len = strlen($characters); $i < $len; $i++) {
                $char = $characters[$i];
                if ($char === "\x0A") {
                    // remove before whitespace char
                    if ($hasWhiteSpace) {
                        $compactCharacters = substr($compactCharacters, 0, -1);
                    }
                    $compactCharacters .= $char;
                    $hasWhiteSpace = true;
                } else if ($char === ' ' || $char === "\x09" || $char === "\x0C") {
                    if (!$hasWhiteSpace) {
                        $compactCharacters .= ' ';
                        $hasWhiteSpace = true;
                    }
                } else {
                    $hasWhiteSpace = false;
                    $compactCharacters .= $char;
                }
            }
            return $compactCharacters;
        }
        protected function optimizeStartTagAttributes() {
            $tokens = $this->tokens;
            for ($i = 0, $len = count($tokens); $i < $len; $i++) {
                $token = $tokens[$i];
                if ($token->getType() !== HTMLToken::StartTag) {
                    continue;
                }
                $attributes_old = $token->getAttributes();
                $attributes_new =array();
                $attributes_name = array();
                foreach ($attributes_old as $attribute) {
                    if (!isset($attributes_name[$attribute['name']])) {
                        $attributes_name[$attribute['name']] = true;
                        $attributes_new[] = $attribute;
                    }
                }
                if ($attributes_old !== $attributes_new) {
                    $token->setAttributes($attributes_new);
                }
            }
            $this->tokens = $tokens;
        }
        /**
         * downlevel-hidden : <!--[if expression]> HTML <![endif]-->
         * downlevel-revealed : <![if expression]> HTML <![endif]>
         * @param string $comment
         * @return bool
         */
        protected function _isConditionalComment($comment) {
            $pattern = '/\A<!(?:--)?\[if [^\]]+\]>/s';
            if (preg_match($pattern, $comment)) {
                return true;
            }
            $pattern = '/<!\[endif\](?:--)?>\Z/s';
            if (preg_match($pattern, $comment)) {
                return true;
            }
            return false;
        }
    }

    class SegmentedString {
        const ENCODING = 'UTF-8';
        const DidNotMatch = 'DidNotMatch';
        const DidMatch = 'DidMatch';
        const NotEnoughCharacters = 'NotEnoughCharacters';
        const begin = 0;
        const current = 1;
        const end = 2;
        protected $str;
        protected $i = 0;
        protected $len = 0;
        /**
         * @param $str
         */
        public function __construct($str) {
            $this->str = $str;
            $this->len = strlen($str);
        }
        /**
         * @return bool|string
         */
        public function  getCurrentChar() {
            $i = $this->i;
            if ($this->len <= $i) {
                return false;
            }
            return $this->str[$i];
        }
        public function advance() {
            $this->i += 1;
        }
        /**
         * @param int $i
         * @return string
         */
        public function read($i) {
            if ($this->eos() && $i > 0) {
                return false;
            }
            $this->i += $i;
            return substr($this->str, $this->i - $i, $i);
        }
        /**
         * @param int $startPos
         * @param int $length
         * @return string
         */
        public function substr($startPos, $length) {
            return substr($this->str, $startPos, $length);
        }
        /**
         * @param int $offset
         * @param int $whence
         * @throws \InvalidArgumentException
         * @return bool
         */
        public function seek($offset, $whence = self::begin) {
            switch ($whence) {
                case static::begin:
                    if ($this->len < $offset) {
                        return false;
                    }
                    $this->i = $offset;
                    return true;
                    break;
                case static::current:
                    $lookAhead = $this->i + $offset;
                    if ($lookAhead < 0 || $lookAhead > $this->len) {
                        return false;
                    }
                    $this->i = $lookAhead;
                    return true;
                    break;
            }
            throw new \InvalidArgumentException;
        }
        /**
         * @return int
         */
        public function tell() {
            return $this->i;
        }
        /**
         * @return bool
         */
        public function eos() {
            return $this->len <= $this->i;
        }
        public function get() {
            return $this->str;
        }
        public function len() {
            return $this->len;
        }
        public function token($str, $caseSensitive = true) {
            $matched = $this->read(strlen($str));
            if ($caseSensitive) {
                return $str === $matched ? $str : false;
            } else {
                return strtolower($str) === strtolower($matched) ? $matched : false;
            }
        }
        public function lookAheadIgnoringCase($str) {
            return $this->_lookAhead($str, false);
        }
        public function lookAhead($str) {
            return $this->_lookAhead($str, true);
        }
        protected function _lookAhead($str, $caseSensitive = true) {
            $i = $this->i;
            $result = $this->token($str, $caseSensitive) !== false;
            $this->seek($i);
            if (strlen($str) + $i <= $this->len) {
                if ($result) {
                    return static::DidMatch;
                }
                return static::DidNotMatch;
            }
            return static::NotEnoughCharacters;
        }
        // int numberOfCharactersConsumed() const { return m_string.length() - m_length; }
        public function numberOfCharactersConsumed() {
            // int numberOfPushedCharacters = 0;
            // if (m_pushedChar1) {
            //     ++numberOfPushedCharacters;
            //     if (m_pushedChar2)
            //         ++numberOfPushedCharacters;
            // }
            // return m_numberOfCharactersConsumedPriorToCurrentString + m_currentString.numberOfCharactersConsumed() - numberOfPushedCharacters;
            return $this->i;
        }
    }

    class HTMLTokenizer {
        const DataState = 'DataState';
        const CharacterReferenceInDataState = 'CharacterReferenceInDataState';
        const RCDATAState = 'RCDATAState';
        const CharacterReferenceInRCDATAState = 'CharacterReferenceInRCDATAState';
        const RAWTEXTState = 'RAWTEXTState';
        const ScriptDataState = 'ScriptDataState';
        const PLAINTEXTState = 'PLAINTEXTState';
        const TagOpenState = 'TagOpenState';
        const EndTagOpenState = 'EndTagOpenState';
        const TagNameState = 'TagNameState';
        const RCDATALessThanSignState = 'RCDATALessThanSignState';
        const RCDATAEndTagOpenState = 'RCDATAEndTagOpenState';
        const RCDATAEndTagNameState = 'RCDATAEndTagNameState';
        const RAWTEXTLessThanSignState = 'RAWTEXTLessThanSignState';
        const RAWTEXTEndTagOpenState = 'RAWTEXTEndTagOpenState';
        const RAWTEXTEndTagNameState = 'RAWTEXTEndTagNameState';
        const ScriptDataLessThanSignState = 'ScriptDataLessThanSignState';
        const ScriptDataEndTagOpenState = 'ScriptDataEndTagOpenState';
        const ScriptDataEndTagNameState = 'ScriptDataEndTagNameState';
        const ScriptDataEscapeStartState = 'ScriptDataEscapeStartState';
        const ScriptDataEscapeStartDashState = 'ScriptDataEscapeStartDashState';
        const ScriptDataEscapedState = 'ScriptDataEscapedState';
        const ScriptDataEscapedDashState = 'ScriptDataEscapedDashState';
        const ScriptDataEscapedDashDashState = 'ScriptDataEscapedDashDashState';
        const ScriptDataEscapedLessThanSignState = 'ScriptDataEscapedLessThanSignState';
        const ScriptDataEscapedEndTagOpenState = 'ScriptDataEscapedEndTagOpenState';
        const ScriptDataEscapedEndTagNameState = 'ScriptDataEscapedEndTagNameState';
        const ScriptDataDoubleEscapeStartState = 'ScriptDataDoubleEscapeStartState';
        const ScriptDataDoubleEscapedState = 'ScriptDataDoubleEscapedState';
        const ScriptDataDoubleEscapedDashState = 'ScriptDataDoubleEscapedDashState';
        const ScriptDataDoubleEscapedDashDashState = 'ScriptDataDoubleEscapedDashDashState';
        const ScriptDataDoubleEscapedLessThanSignState = 'ScriptDataDoubleEscapedLessThanSignState';
        const ScriptDataDoubleEscapeEndState = 'ScriptDataDoubleEscapeEndState';
        const BeforeAttributeNameState = 'BeforeAttributeNameState';
        const AttributeNameState = 'AttributeNameState';
        const AfterAttributeNameState = 'AfterAttributeNameState';
        const BeforeAttributeValueState = 'BeforeAttributeValueState';
        const AttributeValueDoubleQuotedState = 'AttributeValueDoubleQuotedState';
        const AttributeValueSingleQuotedState = 'AttributeValueSingleQuotedState';
        const AttributeValueUnquotedState = 'AttributeValueUnquotedState';
        const CharacterReferenceInAttributeValueState = 'CharacterReferenceInAttributeValueState';
        const AfterAttributeValueQuotedState = 'AfterAttributeValueQuotedState';
        const SelfClosingStartTagState = 'SelfClosingStartTagState';
        const BogusCommentState = 'BogusCommentState';
        const ContinueBogusCommentState = 'ContinueBogusCommentState';
        const MarkupDeclarationOpenState = 'MarkupDeclarationOpenState';
        const CommentStartState = 'CommentStartState';
        const CommentStartDashState = 'CommentStartDashState';
        const CommentState = 'CommentState';
        const CommentEndDashState = 'CommentEndDashState';
        const CommentEndState = 'CommentEndState';
        const CommentEndBangState = 'CommentEndBangState';
        const DOCTYPEState = 'DOCTYPEState';
        const BeforeDOCTYPENameState = 'BeforeDOCTYPENameState';
        const DOCTYPENameState = 'DOCTYPENameState';
        const AfterDOCTYPENameState = 'AfterDOCTYPENameState';
        const AfterDOCTYPEPublicKeywordState = 'AfterDOCTYPEPublicKeywordState';
        const BeforeDOCTYPEPublicIdentifierState = 'BeforeDOCTYPEPublicIdentifierState';
        const DOCTYPEPublicIdentifierDoubleQuotedState = 'DOCTYPEPublicIdentifierDoubleQuotedState';
        const DOCTYPEPublicIdentifierSingleQuotedState = 'DOCTYPEPublicIdentifierSingleQuotedState';
        const AfterDOCTYPEPublicIdentifierState = 'AfterDOCTYPEPublicIdentifierState';
        const BetweenDOCTYPEPublicAndSystemIdentifiersState = 'BetweenDOCTYPEPublicAndSystemIdentifiersState';
        const AfterDOCTYPESystemKeywordState = 'AfterDOCTYPESystemKeywordState';
        const BeforeDOCTYPESystemIdentifierState = 'BeforeDOCTYPESystemIdentifierState';
        const DOCTYPESystemIdentifierDoubleQuotedState = 'DOCTYPESystemIdentifierDoubleQuotedState';
        const DOCTYPESystemIdentifierSingleQuotedState = 'DOCTYPESystemIdentifierSingleQuotedState';
        const AfterDOCTYPESystemIdentifierState = 'AfterDOCTYPESystemIdentifierState';
        const BogusDOCTYPEState = 'BogusDOCTYPEState';
        const CDATASectionState = 'CDATASectionState';
        const CDATASectionRightSquareBracketState = 'CDATASectionRightSquareBracketState';
        const CDATASectionDoubleRightSquareBracketState = 'CDATASectionDoubleRightSquareBracketState';
        // set substr FALSE on failure
        const kEndOfFileMarker = false;
        /**
         * @var SegmentedString
         */
        protected $_SegmentedString;
        /**
         * @var HtmlToken
         */
        protected $_Token;
        protected $_pluginsEnabled = true;
        protected $_scriptEnabled = true;
        protected $_stack = array();
        protected $_buffer = array();
        protected $_startPos = 0;
        /**
         * @var HtmlToken[]
         */
        protected $_tokens = array();
        protected $_state;
        protected $_startState;
        protected $_additionalAllowedCharacter = null;
        /**
         * @var string
         */
        protected $_temporaryBuffer = '';
        /**
         * @var string
         */
        protected $_bufferedEndTagName = '';
        /**
         * @var string
         */
        protected $_appropriateEndTagName = '';
        /**
         * @var bool
         */
        protected $_debug = false;
        public function __construct(SegmentedString $SegmentedString, $option = array()) {
            $this->_SegmentedString = $SegmentedString;
            $this->_Token = new HTMLToken();
            $this->_state = static::DataState;
            $this->_startState = static::DataState;
            $this->_option = $option + array('debug' => false);
            $this->_debug = !!$this->_option['debug'];
        }
        /**
         * @param string $state
         */
        public function setState($state) {
            $this->_state = $state;
        }
        /**
         * @return string
         */
        public function getState() {
            return $this->_state;
        }
        /**
         * @throws \InvalidArgumentException
         * @return HtmlToken[]
         */
        public function tokenizer() {
            if ($this->_SegmentedString->eos()) {
                return array();
            }
            while (true) {
                $this->_startPos = $startPos = $this->_SegmentedString->tell();
                $result = $this->nextToken($this->_SegmentedString);
                $this->_state = static::DataState;
                $endPos = $this->_SegmentedString->tell();
                if ($result === false && (($endPos - $startPos) === 0)) {
                    throw new \InvalidArgumentException('Given invalid string or invalid statement.');
                }
                $startState = $this->_startState;
                // In other than `DataState`, `nextToken` return the type of Character, it contains the type of EndTag.
                // SegmentedString go back to the end of the type of Character position.
                $type = $this->_Token->getType();
                if ($type === HTMLToken::Character && $this->_bufferedEndTagName !== '' && ($startState === static::RAWTEXTState || $startState === static::RCDATAState || $startState === static::ScriptDataState)) {
                    $length = strlen($this->_Token->getData());
                    // HTMLToken::Character
                    $this->_buffer = array_slice($this->_buffer, 0, $length);
                    $this->_compactBuffer($startPos, $startPos + $length, $type);
                    $token = $this->_Token;
                    $this->_tokens[] = $token;
                    // process again for type of EndTag
                    $this->_SegmentedString->seek($startPos + $length);
                    $this->_state = $startState;
                } else {
                    $this->_compactBuffer($startPos, $endPos, $type);
                    $token = $this->_Token;
                    $this->_tokens[] = $token;
                    // FIXME: The tokenizer should do this work for us.
                    if ($type === HTMLToken::StartTag) {
                        $this->_updateStateFor($token->getTagName());
                    } else {
                        $this->_state = static::DataState;
                    }
                }
                $this->_startState = $this->_state;
                $this->_buffer = array();
                $this->_bufferedEndTagName = '';
                $this->_temporaryBuffer = '';
                $this->_Token = new HTMLToken();
                if ($this->_SegmentedString->eos()) {
                    break;
                }
            }
            return $this->_tokens;
        }
        public function getTokensAsArray() {
            $result = array();
            foreach ($this->_tokens as $token) {
                $result[] = $token->toArray();
            }
            return $result;
        }
        protected function _compactBuffer($startPos, $endPos, $type) {
            $compactBuffer = array();
            $before = static::kEndOfFileMarker;
            $html = $this->_SegmentedString->substr($startPos, $endPos - $startPos);
            foreach ($this->_buffer as $i => $state) {
                if ($before !== $state) {
                    $before = $compactBuffer[$i] = $state;
                }
            }
            switch ($type) {
                case HTMLToken::Uninitialized:
                case HTMLToken::EndOfFile:
                case HTMLToken::Character:
                case HTMLToken::Comment:
                    $this->_Token->setData($html);
                    break;
            }
            if ($this->_debug) {
                $this->_Token->setHtmlOrigin($html);
                $this->_Token->setState($compactBuffer);
            } else if ($type === HTMLToken::DOCTYPE) {
                $this->_Token->setHtmlOrigin($html);
            }
            $this->_Token->clean();
        }
        protected function _updateStateFor($tagName) {
            if ($tagName === HTMLNames::textareaTag || $tagName === HTMLNames::titleTag) {
                $this->_state = static::RCDATAState;
            } else if ($tagName === HTMLNames::plaintextTag) {
                $this->_state = static::PLAINTEXTState;
            } else if ($tagName === HTMLNames::scriptTag) {
                $this->_state = static::ScriptDataState;
            } else if ($tagName === HTMLNames::styleTag || $tagName === HTMLNames::iframeTag || $tagName === HTMLNames::xmpTag || ($tagName === HTMLNames::noembedTag && $this->_pluginsEnabled) || $tagName === HTMLNames::noframesTag || ($tagName === HTMLNames::noscriptTag && $this->_scriptEnabled)) {
                $this->_state = static::RAWTEXTState;
            }
        }
        // http://www.whatwg.org/specs/web-apps/current-work/#tokenization
        protected function nextToken(SegmentedString $source) {
            while (true) {
                $char = $this->_SegmentedString->getCurrentChar();
                switch ($this->_state) {
                    case static::DataState:
                        if ($char === '&') {
                            $this->_HTML_ADVANCE_TO(static::CharacterReferenceInDataState);
                        } else if ($char === '<') {
                            if ($this->_Token->getType() === HTMLToken::Character) {
                                // We have a bunch of character tokens queued up that we
                                // are emitting lazily here.
                                return true;
                            }
                            $this->_HTML_ADVANCE_TO(static::TagOpenState);
                        } else if ($char === static::kEndOfFileMarker) {
                            return $this->_emitEndOfFile();
                        } else {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::DataState);
                        }
                        break;
                    case static::CharacterReferenceInDataState:
                        // TODO Do not expand the reference, so skip parse Character references.
                        $this->_HTML_SWITCH_TO(static::DataState);
                        break;
                    case static::RCDATAState:
                        if ($char === '&') {
                            $this->_HTML_ADVANCE_TO(static::CharacterReferenceInRCDATAState);
                        } else if ($char === '<') {
                            $this->_HTML_ADVANCE_TO(static::RCDATALessThanSignState);
                        } else if ($char === static::kEndOfFileMarker) {
                            return $this->_emitEndOfFile();
                        } else {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::RCDATAState);
                        }
                        break;
                    case static::CharacterReferenceInRCDATAState:
                        // TODO Do not expand the reference, so skip parse Character references.
                        $this->_HTML_SWITCH_TO(static::RCDATAState);
                        break;
                    case static::RAWTEXTState:
                        if ($char === '<') {
                            $this->_HTML_ADVANCE_TO(static::RAWTEXTLessThanSignState);
                        } else if ($char === static::kEndOfFileMarker) {
                            return $this->_emitEndOfFile();
                        } else {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::RAWTEXTState);
                        }
                        break;
                    case static::ScriptDataState:
                        if ($char === '<') {
                            $this->_HTML_ADVANCE_TO(static::ScriptDataLessThanSignState);
                        } else if ($char === static::kEndOfFileMarker) {
                            return $this->_emitEndOfFile();
                        } else {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataState);
                        }
                        break;
                    case static::PLAINTEXTState:
                        if ($char === static::kEndOfFileMarker) {
                            return $this->_emitEndOfFile();
                        } else {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::PLAINTEXTState);
                        }
                        break;
                    case static::TagOpenState:
                        if ($char === '!') {
                            $this->_HTML_ADVANCE_TO(static::MarkupDeclarationOpenState);
                        } else if ($char === '/') {
                            $this->_HTML_ADVANCE_TO(static::EndTagOpenState);
                        } else if (ctype_upper($char)) {
                            $this->_Token->beginStartTag(strtolower($char));
                            $this->_HTML_ADVANCE_TO(static::TagNameState);
                        } else if (ctype_lower($char)) {
                            $this->_Token->beginStartTag(strtolower($char));
                            $this->_HTML_ADVANCE_TO(static::TagNameState);
                        } else if ($char === '?') {
                            $this->_parseError();
                            // The spec consumes the current character before switching
                            // to the bogus comment state, but it's easier to implement
                            // if we reconsume the current character.
                            $this->_HTML_RECONSUME_IN(static::BogusCommentState);
                        } else {
                            $this->_parseError();
                            $this->_bufferCharacter('<');
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        }
                        break;
                    case static::EndTagOpenState:
                        if (ctype_upper($char)) {
                            $this->_Token->beginEndTag(strtolower($char));
                            $this->_HTML_ADVANCE_TO(static::TagNameState);
                        } else if (ctype_lower($char)) {
                            $this->_Token->beginEndTag(strtolower($char));
                            $this->_HTML_ADVANCE_TO(static::TagNameState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            $this->_HTML_ADVANCE_TO(static::DataState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_bufferCharacter('<');
                            $this->_bufferCharacter('/');
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::BogusCommentState);
                        }
                        break;
                    case static::TagNameState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::BeforeAttributeNameState);
                        } else if ($char === '/') {
                            $this->_HTML_ADVANCE_TO(static::SelfClosingStartTagState);
                        } else if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if (ctype_upper($char)) {
                            $this->_Token->appendToName(strtolower($char));
                            $this->_HTML_ADVANCE_TO(static::TagNameState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_Token->appendToName($char);
                            $this->_HTML_ADVANCE_TO(static::TagNameState);
                        }
                        break;
                    case static::RCDATALessThanSignState:
                        if ($char === '/') {
                            $this->_temporaryBuffer = '';
                            $this->_HTML_ADVANCE_TO(static::RCDATAEndTagOpenState);
                        } else {
                            $this->_bufferCharacter('<');
                            $this->_HTML_RECONSUME_IN(static::RCDATAState);
                        }
                        break;
                    case static::RCDATAEndTagOpenState:
                        if (ctype_upper($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= strtolower($char);
                            $this->_HTML_ADVANCE_TO(static::RCDATAEndTagNameState);
                        } else if (ctype_lower($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= $char;
                            $this->_HTML_ADVANCE_TO(static::RCDATAEndTagNameState);
                        } else {
                            $this->_bufferCharacter('<');
                            $this->_bufferCharacter('/');
                            $this->_HTML_RECONSUME_IN(static::RCDATAState);
                        }
                        break;
                    case static::RCDATAEndTagNameState:
                        if (ctype_upper($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= strtolower($char);
                            $this->_HTML_ADVANCE_TO(static::RCDATAEndTagNameState);
                        } else if (ctype_lower($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= $char;
                            $this->_HTML_ADVANCE_TO(static::RCDATAEndTagNameState);
                        } else {
                            if ($this->_isTokenizerWhitespace($char)) {
                                if ($this->_isAppropriateEndTag()) {
                                    $this->_temporaryBuffer .= $char;
                                    $result = $this->_FLUSH_AND_ADVANCE_TO(static::BeforeAttributeNameState);
                                    if ($result !== null) {
                                        return $result;
                                    }
                                    break;
                                }
                            } else if ($char === '/') {
                                if ($this->_isAppropriateEndTag()) {
                                    $this->_temporaryBuffer .= $char;
                                    $result = $this->_FLUSH_AND_ADVANCE_TO(static::SelfClosingStartTagState);
                                    if ($result !== null) {
                                        return $result;
                                    }
                                    break;
                                }
                            } else if ($char === '>') {
                                if ($this->_isAppropriateEndTag()) {
                                    $this->_temporaryBuffer .= $char;
                                    return $this->_flushEmitAndResumeIn($source, HTMLTokenizer::DataState);
                                }
                            }
                            $this->_bufferCharacter('<');
                            $this->_bufferCharacter('/');
                            $this->_Token->appendToCharacter($this->_temporaryBuffer);
                            $this->_bufferedEndTagName = '';
                            $this->_temporaryBuffer = '';
                            $this->_HTML_RECONSUME_IN(static::RCDATAState);
                        }
                        break;
                    case static::RAWTEXTLessThanSignState:
                        if ($char === '/') {
                            $this->_temporaryBuffer = '';
                            $this->_HTML_ADVANCE_TO(static::RAWTEXTEndTagOpenState);
                        } else {
                            $this->_bufferCharacter('<');
                            $this->_HTML_RECONSUME_IN(static::RAWTEXTState);
                        }
                        break;
                    case static::RAWTEXTEndTagOpenState:
                        if (ctype_upper($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= strtolower($char);
                            $this->_HTML_ADVANCE_TO(static::RAWTEXTEndTagNameState);
                        } else if (ctype_lower($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= $char;
                            $this->_HTML_ADVANCE_TO(static::RAWTEXTEndTagNameState);
                        } else {
                            $this->_bufferCharacter('<');
                            $this->_bufferCharacter('/');
                            $this->_HTML_RECONSUME_IN(static::RAWTEXTState);
                        }
                        break;
                    case static::RAWTEXTEndTagNameState:
                        if (ctype_upper($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= strtolower($char);
                            $this->_HTML_ADVANCE_TO(static::RAWTEXTEndTagNameState);
                        } else if (ctype_lower($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= $char;
                            $this->_HTML_ADVANCE_TO(static::RAWTEXTEndTagNameState);
                        } else {
                            if ($this->_isTokenizerWhitespace($char)) {
                                if ($this->_isAppropriateEndTag()) {
                                    $this->_temporaryBuffer .= $char;
                                    $result = $this->_FLUSH_AND_ADVANCE_TO(static::BeforeAttributeNameState);
                                    if ($result !== null) {
                                        return $result;
                                    }
                                    break;
                                }
                            } else if ($char === '/') {
                                if ($this->_isAppropriateEndTag()) {
                                    $this->_temporaryBuffer .= $char;
                                    $result = $this->_FLUSH_AND_ADVANCE_TO(static::SelfClosingStartTagState);
                                    if ($result !== null) {
                                        return $result;
                                    }
                                    break;
                                }
                            } else if ($char === '>') {
                                if ($this->_isAppropriateEndTag()) {
                                    $this->_temporaryBuffer .= $char;
                                    return $this->_flushEmitAndResumeIn($source, HTMLTokenizer::DataState);
                                }
                            }
                            $this->_bufferCharacter('<');
                            $this->_bufferCharacter('/');
                            $this->_Token->appendToCharacter($this->_temporaryBuffer);
                            $this->_bufferedEndTagName = '';
                            $this->_temporaryBuffer = '';
                            $this->_HTML_RECONSUME_IN(static::RAWTEXTState);
                        }
                        break;
                    case static::ScriptDataLessThanSignState:
                        if ($char === '/') {
                            $this->_temporaryBuffer = '';
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEndTagOpenState);
                        } else if ($char === '!') {
                            $this->_bufferCharacter('<');
                            $this->_bufferCharacter('!');
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapeStartState);
                        } else {
                            $this->_bufferCharacter('<');
                            $this->_HTML_RECONSUME_IN(static::ScriptDataState);
                        }
                        break;
                    case static::ScriptDataEndTagOpenState:
                        if (ctype_upper($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= strtolower($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEndTagNameState);
                        } else if (ctype_lower($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= $char;
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEndTagNameState);
                        } else {
                            $this->_bufferCharacter('<');
                            $this->_bufferCharacter('/');
                            $this->_HTML_RECONSUME_IN(static::ScriptDataState);
                        }
                        break;
                    case static::ScriptDataEndTagNameState:
                        if (ctype_upper($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= strtolower($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEndTagNameState);
                        } else if (ctype_lower($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= $char;
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEndTagNameState);
                        } else {
                            if ($this->_isTokenizerWhitespace($char)) {
                                if ($this->_isAppropriateEndTag()) {
                                    $this->_temporaryBuffer .= $char;
                                    $result = $this->_FLUSH_AND_ADVANCE_TO(static::BeforeAttributeNameState);
                                    if ($result !== null) {
                                        return $result;
                                    }
                                    break;
                                }
                            } else if ($char === '/') {
                                if ($this->_isAppropriateEndTag()) {
                                    $this->_temporaryBuffer .= $char;
                                    $result = $this->_FLUSH_AND_ADVANCE_TO(static::SelfClosingStartTagState);
                                    if ($result !== null) {
                                        return $result;
                                    }
                                    break;
                                }
                            } else if ($char === '>') {
                                if ($this->_isAppropriateEndTag()) {
                                    $this->_temporaryBuffer .= $char;
                                    return $this->_flushEmitAndResumeIn($source, HTMLTokenizer::DataState);
                                }
                            }
                            $this->_bufferCharacter('<');
                            $this->_bufferCharacter('/');
                            $this->_Token->appendToCharacter($this->_temporaryBuffer);
                            $this->_bufferedEndTagName = '';
                            $this->_temporaryBuffer = '';
                            $this->_HTML_RECONSUME_IN(static::ScriptDataState);
                        }
                        break;
                    case static::ScriptDataEscapeStartState:
                        if ($char === '-') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapeStartDashState);
                        } else {
                            $this->_HTML_RECONSUME_IN(static::ScriptDataState);
                        }
                        break;
                    case static::ScriptDataEscapeStartDashState:
                        if ($char === '-') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedDashDashState);
                        } else {
                            $this->_HTML_RECONSUME_IN(static::ScriptDataState);
                        }
                        break;
                    case static::ScriptDataEscapedState:
                        if ($char === '-') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedDashState);
                        } else if ($char === '<') {
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedLessThanSignState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedState);
                        }
                        break;
                    case static::ScriptDataEscapedDashState:
                        if ($char === '-') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedDashDashState);
                        } else if ($char === '<') {
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedLessThanSignState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedState);
                        }
                        break;
                    case static::ScriptDataEscapedDashDashState:
                        if ($char === '-') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedDashDashState);
                        } else if ($char === '<') {
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedLessThanSignState);
                        } else if ($char === '>') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedState);
                        }
                        break;
                    case static::ScriptDataEscapedLessThanSignState:
                        if ($char === '/') {
                            $this->_temporaryBuffer = '';
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedEndTagOpenState);
                        } else if (ctype_upper($char)) {
                            $this->_bufferCharacter('<');
                            $this->_bufferCharacter($char);
                            $this->_temporaryBuffer = '';
                            $this->_temporaryBuffer = strtolower($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapeStartState);
                        } else if (ctype_lower($char)) {
                            $this->_bufferCharacter('<');
                            $this->_bufferCharacter($char);
                            $this->_temporaryBuffer = '';
                            $this->_temporaryBuffer .= $char;
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapeStartState);
                        } else {
                            $this->_bufferCharacter('<');
                            $this->_HTML_RECONSUME_IN(static::ScriptDataEscapedState);
                        }
                        break;
                    case static::ScriptDataEscapedEndTagOpenState:
                        if (ctype_upper($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= strtolower($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedEndTagNameState);
                        } else if (ctype_lower($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= $char;
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedEndTagNameState);
                        } else {
                            $this->_bufferCharacter('<');
                            $this->_bufferCharacter('/');
                            $this->_HTML_RECONSUME_IN(static::ScriptDataEscapedState);
                        }
                        break;
                    case static::ScriptDataEscapedEndTagNameState:
                        if (ctype_upper($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= strtolower($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedEndTagNameState);
                        } else if (ctype_lower($char)) {
                            $this->_temporaryBuffer .= $char;
                            $this->_bufferedEndTagName .= $char;
                            $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedEndTagNameState);
                        } else {
                            if ($this->_isTokenizerWhitespace($char)) {
                                if ($this->_isAppropriateEndTag()) {
                                    $this->_temporaryBuffer .= $char;
                                    // ScriptDataEscapeStartState called bufferCharacter, so `_FLUSH_AND_ADVANCE_TO` always returns true.
                                    return $this->_FLUSH_AND_ADVANCE_TO(static::BeforeAttributeNameState);
                                }
                            } else if ($char === '/') {
                                if ($this->_isAppropriateEndTag()) {
                                    $this->_temporaryBuffer .= $char;
                                    // ScriptDataEscapeStartState called bufferCharacter, so `_FLUSH_AND_ADVANCE_TO` always returns true.
                                    return $this->_FLUSH_AND_ADVANCE_TO(static::SelfClosingStartTagState);
                                }
                            } else if ($char === '>') {
                                if ($this->_isAppropriateEndTag()) {
                                    $this->_temporaryBuffer .= $char;
                                    $this->_temporaryBuffer .= $char;
                                    return $this->_flushEmitAndResumeIn($source, HTMLTokenizer::DataState);
                                }
                            }
                            $this->_bufferCharacter('<');
                            $this->_bufferCharacter('/');
                            $this->_Token->appendToCharacter($this->_temporaryBuffer);
                            $this->_bufferedEndTagName = '';
                            $this->_temporaryBuffer = '';
                            $this->_HTML_RECONSUME_IN(static::ScriptDataEscapedState);
                        }
                        break;
                    case static::ScriptDataDoubleEscapeStartState:
                        if ($this->_isTokenizerWhitespace($char) || $char === '/' || $char === '>') {
                            $this->_bufferCharacter($char);
                            if ($this->_temporaryBufferIs(HTMLNames::scriptTag)) {
                                $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapedState);
                            } else {
                                $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedState);
                            }
                        } else if (ctype_upper($char)) {
                            $this->_bufferCharacter($char);
                            $this->_temporaryBuffer .= strtolower($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapeStartState);
                        } else if (ctype_lower($char)) {
                            $this->_bufferCharacter($char);
                            $this->_temporaryBuffer .= $char;
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapeStartState);
                        } else {
                            $this->_HTML_RECONSUME_IN(static::ScriptDataEscapedState);
                        }
                        break;
                    case static::ScriptDataDoubleEscapedState:
                        if ($char === '-') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapedDashState);
                        } else if ($char === '<') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapedLessThanSignState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapedState);
                        }
                        break;
                    case static::ScriptDataDoubleEscapedDashState:
                        if ($char === '-') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapedDashDashState);
                        } else if ($char === '<') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapedLessThanSignState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapedState);
                        }
                        break;
                    case static::ScriptDataDoubleEscapedDashDashState:
                        if ($char === '-') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapedDashDashState);
                        } else if ($char === '<') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapedLessThanSignState);
                        } else if ($char === '>') {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapedState);
                        }
                        break;
                    case static::ScriptDataDoubleEscapedLessThanSignState:
                        if ($char === '/') {
                            $this->_bufferCharacter($char);
                            $this->_temporaryBuffer = '';
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapeEndState);
                        } else
                            $this->_HTML_RECONSUME_IN(static::ScriptDataDoubleEscapedState);
                        break;
                    case static::ScriptDataDoubleEscapeEndState:
                        if ($this->_isTokenizerWhitespace($char) || $char === '/' || $char === '>') {
                            $this->_bufferCharacter($char);
                            if ($this->_temporaryBufferIs(HTMLNames::scriptTag)) {
                                $this->_HTML_ADVANCE_TO(static::ScriptDataEscapedState);
                            } else {
                                $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapedState);
                            }
                        } else if (ctype_upper($char)) {
                            $this->_bufferCharacter($char);
                            $this->_temporaryBuffer .= strtolower($char);
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapeEndState);
                        } else if (ctype_lower($char)) {
                            $this->_bufferCharacter($char);
                            $this->_temporaryBuffer .= $char;
                            $this->_HTML_ADVANCE_TO(static::ScriptDataDoubleEscapeEndState);
                        } else {
                            $this->_HTML_RECONSUME_IN(static::ScriptDataDoubleEscapedState);
                        }
                        break;
                    case static::BeforeAttributeNameState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::BeforeAttributeNameState);
                        } else if ($char === '/') {
                            $this->_HTML_ADVANCE_TO(static::SelfClosingStartTagState);
                        } else if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if (ctype_upper($char)) {
                            $this->_Token->addNewAttribute();
                            $this->_Token->beginAttributeName($source->numberOfCharactersConsumed());
                            $this->_Token->appendToAttributeName(strtolower($char));
                            $this->_HTML_ADVANCE_TO(static::AttributeNameState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            if ($char === '"' || $char === '\'' || $char === '<' || $char === '=') {
                                $this->_parseError();
                            }
                            $this->_Token->addNewAttribute();
                            $this->_Token->beginAttributeName($source->numberOfCharactersConsumed());
                            $this->_Token->appendToAttributeName($char);
                            $this->_HTML_ADVANCE_TO(static::AttributeNameState);
                        }
                        break;
                    case static::AttributeNameState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_Token->endAttributeName($source->numberOfCharactersConsumed());
                            $this->_HTML_ADVANCE_TO(static::AfterAttributeNameState);
                        } else if ($char === '/') {
                            $this->_Token->endAttributeName($source->numberOfCharactersConsumed());
                            $this->_HTML_ADVANCE_TO(static::SelfClosingStartTagState);
                        } else if ($char === '=') {
                            $this->_Token->endAttributeName($source->numberOfCharactersConsumed());
                            $this->_HTML_ADVANCE_TO(static::BeforeAttributeValueState);
                        } else if ($char === '>') {
                            $this->_Token->endAttributeName($source->numberOfCharactersConsumed());
                            return $this->_emitAndResumeIn();
                        } else if (ctype_upper($char)) {
                            $this->_Token->appendToAttributeName(strtolower($char));
                            $this->_HTML_ADVANCE_TO(static::AttributeNameState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->endAttributeName($source->numberOfCharactersConsumed());
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            if ($char === '"' || $char === '\'' || $char === '<' || $char === '=') {
                                $this->_parseError();
                            }
                            $this->_Token->appendToAttributeName($char);
                            $this->_HTML_ADVANCE_TO(static::AttributeNameState);
                        }
                        break;
                    case static::AfterAttributeNameState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::AfterAttributeNameState);
                        } else if ($char === '/') {
                            $this->_HTML_ADVANCE_TO(static::SelfClosingStartTagState);
                        } else if ($char === '=') {
                            $this->_HTML_ADVANCE_TO(static::BeforeAttributeValueState);
                        } else if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if (ctype_upper($char)) {
                            $this->_Token->addNewAttribute();
                            $this->_Token->beginAttributeName($source->numberOfCharactersConsumed());
                            $this->_Token->appendToAttributeName(strtolower($char));
                            $this->_HTML_ADVANCE_TO(static::AttributeNameState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            if ($char === '"' || $char === '\'' || $char === '<') {
                                $this->_parseError();
                            }
                            $this->_Token->addNewAttribute();
                            $this->_Token->beginAttributeName($source->numberOfCharactersConsumed());
                            $this->_Token->appendToAttributeName($char);
                            $this->_HTML_ADVANCE_TO(static::AttributeNameState);
                        }
                        break;
                    case static::BeforeAttributeValueState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::BeforeAttributeValueState);
                        } else if ($char === '"') {
                            $this->_Token->beginAttributeValue($source->numberOfCharactersConsumed() + 1);
                            $this->_HTML_ADVANCE_TO(static::AttributeValueDoubleQuotedState);
                        } else if ($char === '&') {
                            $this->_Token->beginAttributeValue($source->numberOfCharactersConsumed());
                            $this->_HTML_RECONSUME_IN(static::AttributeValueUnquotedState);
                        } else if ($char === '\'') {
                            $this->_Token->beginAttributeValue($source->numberOfCharactersConsumed() + 1);
                            $this->_HTML_ADVANCE_TO(static::AttributeValueSingleQuotedState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            if ($char === '<' || $char === '=' || $char === '`') {
                                $this->_parseError();
                            }
                            $this->_Token->beginAttributeValue($source->numberOfCharactersConsumed());
                            $this->_Token->appendToAttributeValue($char);
                            $this->_HTML_ADVANCE_TO(static::AttributeValueUnquotedState);
                        }
                        break;
                    case static::AttributeValueDoubleQuotedState:
                        if ($char === '"') {
                            $this->_Token->setDoubleQuoted();
                            $this->_Token->endAttributeValue($source->numberOfCharactersConsumed());
                            $this->_HTML_ADVANCE_TO(static::AfterAttributeValueQuotedState);
                        } else if ($char === '&') {
                            $this->_additionalAllowedCharacter = '"';
                            $this->_HTML_ADVANCE_TO(static::CharacterReferenceInAttributeValueState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->endAttributeValue($source->numberOfCharactersConsumed());
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_Token->appendToAttributeValue($char);
                            $this->_HTML_ADVANCE_TO(static::AttributeValueDoubleQuotedState);
                        }
                        break;
                    case static::AttributeValueSingleQuotedState:
                        if ($char === '\'') {
                            $this->_Token->setSingleQuoted();
                            $this->_Token->endAttributeValue($source->numberOfCharactersConsumed());
                            $this->_HTML_ADVANCE_TO(static::AfterAttributeValueQuotedState);
                        } else if ($char === '&') {
                            $this->_additionalAllowedCharacter = '\'';
                            $this->_HTML_ADVANCE_TO(static::CharacterReferenceInAttributeValueState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->endAttributeValue($source->numberOfCharactersConsumed());
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_Token->appendToAttributeValue($char);
                            $this->_HTML_ADVANCE_TO(static::AttributeValueSingleQuotedState);
                        }
                        break;
                    case static::AttributeValueUnquotedState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_Token->endAttributeValue($source->numberOfCharactersConsumed());
                            $this->_HTML_ADVANCE_TO(static::BeforeAttributeNameState);
                        } else if ($char === '&') {
                            $this->_additionalAllowedCharacter = '>';
                            $this->_HTML_ADVANCE_TO(static::CharacterReferenceInAttributeValueState);
                        } else if ($char === '>') {
                            $this->_Token->endAttributeValue($source->numberOfCharactersConsumed());
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->endAttributeValue($source->numberOfCharactersConsumed());
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            if ($char === '"' || $char === '\'' || $char === '<' || $char === '=' || $char === '`') {
                                $this->_parseError();
                            }
                            $this->_Token->appendToAttributeValue($char);
                            $this->_HTML_ADVANCE_TO(static::AttributeValueUnquotedState);
                        }
                        break;
                    case static::CharacterReferenceInAttributeValueState:
                        // TODO Do not expand the reference, so skip parse Character references.
                        $this->_Token->appendToAttributeValue('&');
                        // We're supposed to switch back to the attribute value state that
                        // we were in when we were switched into this state. Rather than
                        // keeping track of this explictly, we observe that the previous
                        // state can be determined by $this->_additionalAllowedCharacter.
                        if ($this->_additionalAllowedCharacter === '"') {
                            $this->_HTML_SWITCH_TO(static::AttributeValueDoubleQuotedState);
                        } else if ($this->_additionalAllowedCharacter === '\'') {
                            $this->_HTML_SWITCH_TO(static::AttributeValueSingleQuotedState);
                        } else if ($this->_additionalAllowedCharacter === '>') {
                            $this->_HTML_SWITCH_TO(static::AttributeValueUnquotedState);
                        } else {
                            // ASSERT_NOT_REACHED();
                        }
                        break;
                    case static::AfterAttributeValueQuotedState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::BeforeAttributeNameState);
                        } else if ($char === '/') {
                            $this->_HTML_ADVANCE_TO(static::SelfClosingStartTagState);
                        } else if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::BeforeAttributeNameState);
                        }
                        break;
                    case static::SelfClosingStartTagState:
                        if ($char === '>') {
                            $this->_Token->setSelfClosing();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::BeforeAttributeNameState);
                        }
                        break;
                    case static::BogusCommentState:
                        $this->_Token->beginComment();
                        $this->_HTML_RECONSUME_IN(static::ContinueBogusCommentState);
                        break;
                    case static::ContinueBogusCommentState:
                        if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_Token->appendToComment($char);
                            $this->_HTML_ADVANCE_TO(static::ContinueBogusCommentState);
                        }
                        break;
                    case static::MarkupDeclarationOpenState:
                        $dashDashString = '--';
                        $doctypeString = 'doctype';
                        $cdataString = '[CDATA[';
                        if ($char === '-') {
                            $result = $source->lookAhead($dashDashString);
                            if ($result === SegmentedString::DidMatch) {
                                $this->addState();
                                $this->_SegmentedString->read(strlen('--'));
                                $this->_Token->beginComment();
                                $this->_HTML_SWITCH_TO(static::CommentStartState);
                                continue;
                            } else if ($result === SegmentedString::NotEnoughCharacters) {
                                $this->addState();
                                return $this->_haveBufferedCharacterToken();
                            }
                        } else if ($char === 'D' || $char === 'd') {
                            $result = $this->_SegmentedString->lookAheadIgnoringCase($doctypeString);
                            if ($result === SegmentedString::DidMatch) {
                                $this->addState();
                                $this->_SegmentedString->read(strlen($doctypeString));
                                $this->_HTML_SWITCH_TO(static::DOCTYPEState);
                                continue;
                            } else if ($result === SegmentedString::NotEnoughCharacters) {
                                $this->addState();
                                return $this->_haveBufferedCharacterToken();
                            }
                        } else if ($char === '[' && $this->_shouldAllowCDATA()) {
                            $result = $source->lookAhead($cdataString);
                            if ($result === SegmentedString::DidMatch) {
                                $this->addState();
                                $this->_SegmentedString->read(strlen($cdataString));
                                $this->_HTML_SWITCH_TO(static::CDATASectionState);
                                continue;
                            } else if ($result === SegmentedString::NotEnoughCharacters) {
                                $this->addState();
                                return $this->_haveBufferedCharacterToken();
                            }
                        }
                        $this->_parseError();
                        $this->_HTML_RECONSUME_IN(static::BogusCommentState);
                        break;
                    case static::CommentStartState:
                        if ($char === '-') {
                            $this->_HTML_ADVANCE_TO(static::CommentStartDashState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_Token->appendToComment($char);
                            $this->_HTML_ADVANCE_TO(static::CommentState);
                        }
                        break;
                    case static::CommentStartDashState:
                        if ($char === '-') {
                            $this->_HTML_ADVANCE_TO(static::CommentEndState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_Token->appendToComment('-');
                            $this->_Token->appendToComment($char);
                            $this->_HTML_ADVANCE_TO(static::CommentState);
                        }
                        break;
                    case static::CommentState:
                        if ($char === '-') {
                            $this->_HTML_ADVANCE_TO(static::CommentEndDashState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_Token->appendToComment($char);
                            $this->_HTML_ADVANCE_TO(static::CommentState);
                        }
                        break;
                    case static::CommentEndDashState:
                        if ($char === '-') {
                            $this->_HTML_ADVANCE_TO(static::CommentEndState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_Token->appendToComment('-');
                            $this->_Token->appendToComment($char);
                            $this->_HTML_ADVANCE_TO(static::CommentState);
                        }
                        break;
                    case static::CommentEndState:
                        if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if ($char === '!') {
                            $this->_parseError();
                            $this->_HTML_ADVANCE_TO(static::CommentEndBangState);
                        } else if ($char === '-') {
                            $this->_parseError();
                            $this->_Token->appendToComment('-');
                            $this->_HTML_ADVANCE_TO(static::CommentEndState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError(true);
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_parseError();
                            $this->_Token->appendToComment('-');
                            $this->_Token->appendToComment('-');
                            $this->_Token->appendToComment($char);
                            $this->_HTML_ADVANCE_TO(static::CommentState);
                        }
                        break;
                    case static::CommentEndBangState:
                        if ($char === '-') {
                            $this->_Token->appendToComment('-');
                            $this->_Token->appendToComment('-');
                            $this->_Token->appendToComment('!');
                            $this->_HTML_ADVANCE_TO(static::CommentEndDashState);
                        } else if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError(true);
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_Token->appendToComment('-');
                            $this->_Token->appendToComment('-');
                            $this->_Token->appendToComment('!');
                            $this->_Token->appendToComment($char);
                            $this->_HTML_ADVANCE_TO(static::CommentState);
                        }
                        break;
                    case static::DOCTYPEState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::BeforeDOCTYPENameState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->beginDOCTYPE();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_parseError();
                            $this->_HTML_RECONSUME_IN(static::BeforeDOCTYPENameState);
                        }
                        break;
                    case static::BeforeDOCTYPENameState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::BeforeDOCTYPENameState);
                        } else if (ctype_upper($char)) {
                            $this->_Token->beginDOCTYPE(strtolower($char));
                            $this->_HTML_ADVANCE_TO(static::DOCTYPENameState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            $this->_Token->beginDOCTYPE();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError(true);
                            $this->_Token->beginDOCTYPE();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_Token->beginDOCTYPE($char);
                            $this->_HTML_ADVANCE_TO(static::DOCTYPENameState);
                        }
                        break;
                    case static::DOCTYPENameState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::AfterDOCTYPENameState);
                        } else if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if (ctype_upper($char)) {
                            $this->_Token->appendToName(strtolower($char));
                            $this->_HTML_ADVANCE_TO(static::DOCTYPENameState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError(true);
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_Token->appendToName($char);
                            $this->_HTML_ADVANCE_TO(static::DOCTYPENameState);
                        }
                        break;
                    case static::AfterDOCTYPENameState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::AfterDOCTYPENameState);
                        } else if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError(true);
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            // DEFINE_STATIC_LOCAL(String, publicString, (ASCIILiteral("public")));
                            $publicString = 'public';
                            // DEFINE_STATIC_LOCAL(String, systemString, (ASCIILiteral("system")));
                            $systemString = 'system';
                            if ($char === 'P' || $char === 'p') {
                                $result = $source->lookAheadIgnoringCase($publicString);
                                if ($result === SegmentedString::DidMatch) {
                                    $this->addState();
                                    $this->_HTML_SWITCH_TO(static::AfterDOCTYPEPublicKeywordState);
                                    $this->_SegmentedString->read(strlen($publicString));
                                    continue;
                                }
                                // @todo
                                //  else if ($result === SegmentedString::NotEnoughCharacters) {
                                //  $this->addState();
                                //  return $this->_haveBufferedCharacterToken();
                                //  }
                            } else if ($char === 'S' || $char === 's') {
                                $result = $source->lookAheadIgnoringCase($systemString);
                                if ($result === SegmentedString::DidMatch) {
                                    $this->addState();
                                    $this->_HTML_SWITCH_TO(static::AfterDOCTYPESystemKeywordState);
                                    $this->_SegmentedString->read(strlen($systemString));
                                    continue;
                                }
                                // @todo
                                // else if ($result === SegmentedString::NotEnoughCharacters) {
                                // $this->addState();
                                // return $this->_haveBufferedCharacterToken();
                                // }
                            }
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            $this->_HTML_ADVANCE_TO(static::BogusDOCTYPEState);
                        }
                        break;
                    case static::AfterDOCTYPEPublicKeywordState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::BeforeDOCTYPEPublicIdentifierState);
                        } else if ($char === '"') {
                            $this->_parseError();
                            $this->_Token->setPublicIdentifierToEmptyString();
                            $this->_HTML_ADVANCE_TO(static::DOCTYPEPublicIdentifierDoubleQuotedState);
                        } else if ($char === '\'') {
                            $this->_parseError();
                            $this->_Token->setPublicIdentifierToEmptyString();
                            $this->_HTML_ADVANCE_TO(static::DOCTYPEPublicIdentifierSingleQuotedState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError(true);
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            $this->_HTML_ADVANCE_TO(static::BogusDOCTYPEState);
                        }
                        break;
                    case static::BeforeDOCTYPEPublicIdentifierState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::BeforeDOCTYPEPublicIdentifierState);
                        } else if ($char === '"') {
                            $this->_Token->setPublicIdentifierToEmptyString();
                            $this->_HTML_ADVANCE_TO(static::DOCTYPEPublicIdentifierDoubleQuotedState);
                        } else if ($char === '\'') {
                            $this->_Token->setPublicIdentifierToEmptyString();
                            $this->_HTML_ADVANCE_TO(static::DOCTYPEPublicIdentifierSingleQuotedState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError(true);
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            $this->_HTML_ADVANCE_TO(static::BogusDOCTYPEState);
                        }
                        break;
                    case static::DOCTYPEPublicIdentifierDoubleQuotedState:
                        if ($char === '"') {
                            $this->_HTML_ADVANCE_TO(static::AfterDOCTYPEPublicIdentifierState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_Token->appendToPublicIdentifier($char);
                            $this->_HTML_ADVANCE_TO(static::DOCTYPEPublicIdentifierDoubleQuotedState);
                        }
                        break;
                    case static::DOCTYPEPublicIdentifierSingleQuotedState:
                        if ($char === '\'') {
                            $this->_HTML_ADVANCE_TO(static::AfterDOCTYPEPublicIdentifierState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_Token->appendToPublicIdentifier($char);
                            $this->_HTML_ADVANCE_TO(static::DOCTYPEPublicIdentifierSingleQuotedState);
                        }
                        break;
                    case static::AfterDOCTYPEPublicIdentifierState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::BetweenDOCTYPEPublicAndSystemIdentifiersState);
                        } else if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if ($char === '"') {
                            $this->_parseError();
                            $this->_Token->setSystemIdentifierToEmptyString();
                            $this->_HTML_ADVANCE_TO(static::DOCTYPESystemIdentifierDoubleQuotedState);
                        } else if ($char === '\'') {
                            $this->_parseError();
                            $this->_Token->setSystemIdentifierToEmptyString();
                            $this->_HTML_ADVANCE_TO(static::DOCTYPESystemIdentifierSingleQuotedState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            $this->_HTML_ADVANCE_TO(static::BogusDOCTYPEState);
                        }
                        break;
                    case static::BetweenDOCTYPEPublicAndSystemIdentifiersState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::BetweenDOCTYPEPublicAndSystemIdentifiersState);
                        } else if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if ($char === '"') {
                            $this->_Token->setSystemIdentifierToEmptyString();
                            $this->_HTML_ADVANCE_TO(static::DOCTYPESystemIdentifierDoubleQuotedState);
                        } else if ($char === '\'') {
                            $this->_Token->setSystemIdentifierToEmptyString();
                            $this->_HTML_ADVANCE_TO(static::DOCTYPESystemIdentifierSingleQuotedState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            $this->_HTML_ADVANCE_TO(static::BogusDOCTYPEState);
                        }
                        break;
                    case static::AfterDOCTYPESystemKeywordState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::BeforeDOCTYPESystemIdentifierState);
                        } else if ($char === '"') {
                            $this->_parseError();
                            $this->_Token->setSystemIdentifierToEmptyString();
                            $this->_HTML_ADVANCE_TO(static::DOCTYPESystemIdentifierDoubleQuotedState);
                        } else if ($char === '\'') {
                            $this->_parseError();
                            $this->_Token->setSystemIdentifierToEmptyString();
                            $this->_HTML_ADVANCE_TO(static::DOCTYPESystemIdentifierSingleQuotedState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            $this->_HTML_ADVANCE_TO(static::BogusDOCTYPEState);
                        }
                        break;
                    case static::BeforeDOCTYPESystemIdentifierState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::BeforeDOCTYPESystemIdentifierState);
                            continue;
                        }
                        if ($char === '"') {
                            $this->_Token->setSystemIdentifierToEmptyString();
                            $this->_HTML_ADVANCE_TO(static::DOCTYPESystemIdentifierDoubleQuotedState);
                        } else if ($char === '\'') {
                            $this->_Token->setSystemIdentifierToEmptyString();
                            $this->_HTML_ADVANCE_TO(static::DOCTYPESystemIdentifierSingleQuotedState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            $this->_HTML_ADVANCE_TO(static::BogusDOCTYPEState);
                        }
                        break;
                    case static::DOCTYPESystemIdentifierDoubleQuotedState:
                        if ($char === '"') {
                            $this->_HTML_ADVANCE_TO(static::AfterDOCTYPESystemIdentifierState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_Token->appendToSystemIdentifier($char);
                            $this->_HTML_ADVANCE_TO(static::DOCTYPESystemIdentifierDoubleQuotedState);
                        }
                        break;
                    case static::DOCTYPESystemIdentifierSingleQuotedState:
                        if ($char === '\'') {
                            $this->_HTML_ADVANCE_TO(static::AfterDOCTYPESystemIdentifierState);
                        } else if ($char === '>') {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_Token->appendToSystemIdentifier($char);
                            $this->_HTML_ADVANCE_TO(static::DOCTYPESystemIdentifierSingleQuotedState);
                        }
                        break;
                    case static::AfterDOCTYPESystemIdentifierState:
                        if ($this->_isTokenizerWhitespace($char)) {
                            $this->_HTML_ADVANCE_TO(static::AfterDOCTYPESystemIdentifierState);
                        } else if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_parseError();
                            $this->_Token->setForceQuirks();
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        } else {
                            $this->_parseError();
                            $this->_HTML_ADVANCE_TO(static::BogusDOCTYPEState);
                        }
                        break;
                    case static::BogusDOCTYPEState:
                        if ($char === '>') {
                            return $this->_emitAndResumeIn();
                        } else if ($char === static::kEndOfFileMarker) {
                            return $this->_emitAndReconsumeIn($source, HTMLTokenizer::DataState);
                        }
                        $this->_HTML_ADVANCE_TO(static::BogusDOCTYPEState);
                        break;
                    case static::CDATASectionState:
                        if ($char === ']') {
                            $this->_HTML_ADVANCE_TO(static::CDATASectionRightSquareBracketState);
                        } else if ($char === static::kEndOfFileMarker) {
                            $this->_HTML_RECONSUME_IN(static::DataState);
                        } else {
                            $this->_bufferCharacter($char);
                            $this->_HTML_ADVANCE_TO(static::CDATASectionState);
                        }
                        break;
                    case static::CDATASectionRightSquareBracketState:
                        if ($char === ']') {
                            $this->_HTML_ADVANCE_TO(static::CDATASectionDoubleRightSquareBracketState);
                        } else {
                            $this->_bufferCharacter(']');
                            $this->_HTML_RECONSUME_IN(static::CDATASectionState);
                        }
                        break;
                    case static::CDATASectionDoubleRightSquareBracketState:
                        if ($char === '>') {
                            $this->_HTML_ADVANCE_TO(static::DataState);
                        } else {
                            $this->_bufferCharacter(']');
                            $this->_bufferCharacter(']');
                            $this->_HTML_RECONSUME_IN(static::CDATASectionState);
                        }
                        break;
                    default:
                        break 2;
                }
            }
            // ASSERT_NOT_REACHED
            return false;
        }
        protected function _parseError() {
            $this->_Token->parseError();
            $this->_notImplemented();
        }
        protected function _notImplemented() {
            // Source/core/platform/NotImplemented.h
            // logger
        }
        protected function _temporaryBufferIs($expectedString) {
            return $this->_vectorEqualsString($this->_temporaryBuffer, $expectedString);
        }
        protected function _vectorEqualsString($vector, $string) {
            return $vector === $string;
        }
        protected function _isAppropriateEndTag() {
            return $this->_bufferedEndTagName === $this->_appropriateEndTagName;
        }
        protected function _emitAndReconsumeIn(SegmentedString $source, $state) {
            $this->_saveEndTagNameIfNeeded();
            $this->_state = $state;
            return true;
        }
        protected function _saveEndTagNameIfNeeded() {
            if ($this->_Token->getType() === HTMLToken::StartTag) {
                $this->_appropriateEndTagName = $this->_Token->getName();
            }
        }
        protected function _emitEndOfFile() {
            if ($this->_haveBufferedCharacterToken()) {
                return true;
            }
            $this->_state = HTMLTokenizer::DataState;
            //source.advanceAndUpdateLineNumber();
            //$this->_Token->clear();
            $this->_Token->makeEndOfFile();
            return true;
        }
        protected function _emitAndResumeIn() {
            $this->addState();
            $this->_saveEndTagNameIfNeeded();
            //m_state = state;
            $this->_state = static::DataState;
            //source.advanceAndUpdateLineNumber();
            $this->_SegmentedString->advance();
            return true;
        }
        protected function _flushEmitAndResumeIn(SegmentedString $source, $state) {
            // m_state = state;
            $this->_state = $state;
            $this->_flushBufferedEndTag($source);
            return true;
        }
        protected function _flushBufferedEndTag(SegmentedString $source) {
            $source->advance();
            if ($this->_Token->getType() === HTMLToken::Character) {
                return true;
            }
            $this->_Token->beginEndTag($this->_bufferedEndTagName);
            $this->_bufferedEndTagName = '';
            $this->_appropriateEndTagName = '';
            $this->_temporaryBuffer = '';
            return false;
        }
        protected function _haveBufferedCharacterToken() {
            return $this->_Token->getType() === HTMLToken::Character;
        }
        protected function _bufferCharacter($char) {
            $this->_Token->ensureIsCharacterToken();
            $this->_Token->appendToCharacter($char);
        }
        // todo
        protected function _shouldAllowCDATA() {
            return true;
        }
        protected function _isTokenizerWhitespace($char) {
            return $char === ' ' || $char === "\x0A" || $char === "\x09" || $char === "\x0C";
        }
        protected function _FLUSH_AND_ADVANCE_TO($state) {
            $this->addState();
            $this->_state = $state;
            if ($this->_flushBufferedEndTag($this->_SegmentedString)) {
                return true;
            }
            // if ( !m_inputStreamPreprocessor.peek(source)) return haveBufferedCharacterToken();
            return null;
        }
        protected function _HTML_RECONSUME_IN($state) {
            $this->_state = $state;
        }
        protected function _HTML_SWITCH_TO($state) {
            $this->_state = $state;
        }
        protected function _HTML_ADVANCE_TO($state) {
            $this->addState();
            $this->_state = $state;
            $this->_SegmentedString->advance();
        }
        protected function addState() {
            if (!$this->_debug) {
                return;
            }
            $this->_buffer[$this->_SegmentedString->tell() - $this->_startPos] = $this->_state;
        }
    }

    class HTMLToken {
        const Uninitialized = 'Uninitialized';
        const DOCTYPE = 'DOCTYPE';
        const StartTag = 'StartTag';
        const EndTag = 'EndTag';
        const Comment = 'Comment';
        const Character = 'Character';
        const EndOfFile = 'EndOfFile';
        const QuirksMode = 'QuirksMode';
        const LimitedQuirksMode = 'LimitedQuirksMode';
        const NoQuirksMode = 'NoQuirksMode';
        const DoubleQuoted = '"';
        const SingleQuoted = '\'';
        protected $_type;
        protected $_data = '';
        protected $_selfClosing = false;
        protected $_currentAttribute = 0;
        protected $_attributes = array();
        protected $_parseError = false;
        protected $_doctypeData = array(
            'hasPublicIdentifier' => false,
            'hasSystemIdentifier' => false,
            'publicIdentifier' => '',
            'systemIdentifier' => '',
            'forceQuirks' => false,
        );
        protected $_html = '';
        protected $_state = array();
        public function __construct() {
            $this->_type = static::Uninitialized;
        }
        public function __toString() {
            return $this->_data;
        }
        public function toArray() {
            $data = array(
                'type' => $this->_type,
                'data' => $this->_data,
                'selfClosing' => $this->_selfClosing,
                'attributes' => $this->_attributes,
                'parseError' => $this->_parseError,
                'html' => $this->_html,
                'state' => $this->_state,
            );
            if ($this->getType() === static::DOCTYPE) {
                $doctypeData = $this->_doctypeData;
                if ($doctypeData['forceQuirks']) {
                    $mode = static::QuirksMode;
                } else {
                    $mode = $this->setCompatibilityModeFromDoctype($this->_data, $doctypeData['publicIdentifier'], $doctypeData['systemIdentifier']);
                }
                $doctypeData['mode'] = $mode;
                $data['doctypeData'] = $doctypeData;
            }
            return $data;
        }
        /**
         * Source/core/html/parser/HTMLConstructionSite.cpp
         * HTMLConstructionSite::setCompatibilityModeFromDoctype
         *
         * [QuirksMode]
         * startsWith publicId
         * `+//Silmaril//dtd html Pro v0r11 19970101//`
         * `-//AdvaSoft Ltd//DTD HTML 3.0 asWedit + extensions//`
         * `-//AS//DTD HTML 3.0 asWedit + extensions//`
         * `-//IETF//DTD HTML 2.0 Level 1//`
         * `-//IETF//DTD HTML 2.0 Level 2//`
         * `-//IETF//DTD HTML 2.0 Strict Level 1//`
         * `-//IETF//DTD HTML 2.0 Strict Level 2//`
         * `-//IETF//DTD HTML 2.0 Strict//`
         * `-//IETF//DTD HTML 2.0//`
         * `-//IETF//DTD HTML 2.1E//`
         * `-//IETF//DTD HTML 3.0//`
         * `-//IETF//DTD HTML 3.2 Final//`
         * `-//IETF//DTD HTML 3.2//`
         * `-//IETF//DTD HTML 3//`
         * `-//IETF//DTD HTML Level 0//`
         * `-//IETF//DTD HTML Level 1//`
         * `-//IETF//DTD HTML Level 2//`
         * `-//IETF//DTD HTML Level 3//`
         * `-//IETF//DTD HTML Strict Level 0//`
         * `-//IETF//DTD HTML Strict Level 1//`
         * `-//IETF//DTD HTML Strict Level 2//`
         * `-//IETF//DTD HTML Strict Level 3//`
         * `-//IETF//DTD HTML Strict//`
         * `-//IETF//DTD HTML//`
         * `-//Metrius//DTD Metrius Presentational//`
         * `-//Microsoft//DTD Internet Explorer 2.0 HTML Strict//`
         * `-//Microsoft//DTD Internet Explorer 2.0 HTML//`
         * `-//Microsoft//DTD Internet Explorer 2.0 Tables//`
         * `-//Microsoft//DTD Internet Explorer 3.0 HTML Strict//`
         * `-//Microsoft//DTD Internet Explorer 3.0 HTML//`
         * `-//Microsoft//DTD Internet Explorer 3.0 Tables//`
         * `-//Netscape Comm. Corp.//DTD HTML//`
         * `-//Netscape Comm. Corp.//DTD Strict HTML//`
         * `-//O'Reilly and Associates//DTD HTML 2.0//`
         * `-//O'Reilly and Associates//DTD HTML Extended 1.0//`
         * `-//O'Reilly and Associates//DTD HTML Extended Relaxed 1.0//`
         * `-//SoftQuad Software//DTD HoTMetaL PRO 6.0::19990601::extensions to HTML 4.0//`
         * `-//SoftQuad//DTD HoTMetaL PRO 4.0::19971010::extensions to HTML 4.0//`
         * `-//Spyglass//DTD HTML 2.0 Extended//`
         * `-//SQ//DTD HTML 2.0 HoTMetaL + extensions//`
         * `-//Sun Microsystems Corp.//DTD HotJava HTML//`
         * `-//Sun Microsystems Corp.//DTD HotJava Strict HTML//`
         * `-//W3C//DTD HTML 3 1995-03-24//`
         * `-//W3C//DTD HTML 3.2 Draft//`
         * `-//W3C//DTD HTML 3.2 Final//`
         * `-//W3C//DTD HTML 3.2//`
         * `-//W3C//DTD HTML 3.2S Draft//`
         * `-//W3C//DTD HTML 4.0 Frameset//`
         * `-//W3C//DTD HTML 4.0 Transitional//`
         * `-//W3C//DTD HTML Experimental 19960712//`
         * `-//W3C//DTD HTML Experimental 970421//`
         * `-//W3C//DTD W3 HTML//`
         * `-//W3O//DTD W3 HTML 3.0//`
         * `-//WebTechs//DTD Mozilla HTML 2.0//`
         * `-//WebTechs//DTD Mozilla HTML//`
         *
         * IgnoringCase publicId
         * `-//W3O//DTD W3 HTML Strict 3.0//EN//`
         * `-/W3C/DTD HTML 4.0 Transitional/EN`
         * `HTML`
         *
         * IgnoringCase systemId
         * `http://www.ibm.com/data/dtd/v11/ibmxhtml1-transitional.dtd`
         *
         * systemId.isEmpty() && publicId.startsWith
         * `-//W3C//DTD HTML 4.01 Frameset//`
         * `-//W3C//DTD HTML 4.01 Transitional//`
         *
         * [LimitedQuirksMode]
         * startsWith publicId
         * `-//W3C//DTD XHTML 1.0 Frameset//`
         * `-//W3C//DTD XHTML 1.0 Transitional//`
         *
         * !systemId.isEmpty() && publicId.startsWith
         * `-//W3C//DTD HTML 4.01 Frameset//`
         * `-//W3C//DTD HTML 4.01 Transitional//`
         */
        protected function setCompatibilityModeFromDoctype($name, $publicId, $systemId) {
            if ($name !== 'html') {
                return static::QuirksMode;
            }
            $startsWithPublicId = "/^(?:-\/\/(?:S(?:oftQuad(?: Software\/\/DTD HoTMetaL PRO 6\.0::19990601|\/\/DTD HoTMetaL PRO 4\.0::19971010)::extensions to HTML 4\.0|un Microsystems Corp\.\/\/DTD HotJava(?: Strict)? HTML|Q\/\/DTD HTML 2\.0 HoTMetaL \+ extensions|pyglass\/\/DTD HTML 2\.0 Extended)|W(?:3(?:C\/\/DTD (?:HTML (?:3(?:\.2(?: (?:Draft|Final)|S Draft)?| 1995-03-24)|Experimental (?:19960712|970421)|4\.0 (?:Transitional|Frameset))|W3 HTML)|O\/\/DTD W3 HTML 3\.0)|ebTechs\/\/DTD Mozilla HTML(?: 2\.0)?)|IETF\/\/DTD HTML(?: (?:2\.(?:0(?: (?:Strict(?: Level [12])?|Level [12]))?|1E)|3(?:\.(?:2(?: Final)?|0))?|Strict(?: Level [0123])?|Level [0123]))?|M(?:icrosoft\/\/DTD Internet Explorer [23]\.0 (?:HTML(?: Strict)?|Tables)|etrius\/\/DTD Metrius Presentational)|O'Reilly and Associates\/\/DTD HTML (?:Extend(?:ed Relax)?ed 1|2)\.0|A(?:dvaSoft Ltd|S)\/\/DTD HTML 3\.0 asWedit \+ extensions|Netscape Comm\. Corp\.\/\/DTD(?: Strict)? HTML)|\+\/\/Silmaril\/\/dtd html Pro v0r11 19970101)\/\//";
            $ignoringCasePublicId = '/^(?:-\/(?:\/W3O\/\/DTD W3 HTML Strict 3\.0\/\/EN\/\/|W3C\/DTD HTML 4\.0 Transitional\/EN)|HTML)$/i';
            $ignoringCaseSystemId = '/^http:\/\/www\.ibm\.com\/data\/dtd\/v11\/ibmxhtml1-transitional\.dtd$/i';
            $startsWithPublicId2 = '/^-\/\/W3C\/\/DTD HTML 4\.01 (?:Transitional|Frameset)\/\//';
            if (preg_match($startsWithPublicId, $publicId) || preg_match($ignoringCasePublicId, $publicId) || preg_match($ignoringCaseSystemId, $systemId)) {
                return static::QuirksMode;
            }
            if ($systemId === '' && preg_match($startsWithPublicId2, $publicId)) {
                return static::QuirksMode;
            }
            $pattern1 = '/^-\/\/W3C\/\/DTD XHTML 1\.0 (?:Transitional|Frameset)\/\//';
            $pattern2 = ' /^-\/\/W3C\/\/DTD HTML 4\.01 (?:Transitional|Frameset)\/\//';
            if (preg_match($pattern1, $publicId) || ($systemId !== '' && preg_match($pattern2, $publicId))) {
                return static::LimitedQuirksMode;
            }
            return static::NoQuirksMode;
        }
        public function clean() {
            unset($this->_currentAttribute);
        }
        public function getType() {
            return $this->_type;
        }
        public function getName() {
            return $this->_data;
        }
        public function setType($type) {
            $this->_type = $type;
        }
        public function getHtmlOrigin() {
            return $this->_html;
        }
        public function setHtmlOrigin($html) {
            $this->_html = $html;
        }
        public function getState() {
            return $this->_state;
        }
        public function setState($states) {
            $this->_state = $states;
        }
        public function getTagName() {
            $type = $this->getType();
            if ($type !== static::StartTag && $type !== static::EndTag) {
                return false;
            }
            return $this->getName();
        }
        public function setData($data) {
            $this->_data = $data;
        }
        public function getData() {
            return $this->_data;
        }
        public function getAttributes() {
            return $this->_attributes;
        }
        public function setAttributes($attributes) {
            $this->_attributes = $attributes;
        }
        public function getDoctypeData() {
            return $this->_doctypeData;
        }
        public function hasSelfClosing() {
            return $this->_selfClosing;
        }
        public function hasParseError() {
            return $this->_parseError;
        }
        public function parseError() {
            $this->_parseError = true;
        }
        public function clear() {
            $this->_type = static::Uninitialized;
            $this->_data = '';
        }
        public function ensureIsCharacterToken() {
            $this->_type = static::Character;
        }
        public function makeEndOfFile() {
            $this->_type = static::EndOfFile;
        }
        public function appendToCharacter($character) {
            $this->_data .= $character;
        }
        public function beginComment() {
            $this->_type = static::Comment;
        }
        public function appendToComment($character) {
            $this->_data .= $character;
        }
        public function appendToName($character) {
            $this->_data .= $character;
        }
        public function setDoubleQuoted() {
            $this->_currentAttribute['quoted'] = static::DoubleQuoted;
        }
        public function setSingleQuoted() {
            $this->_currentAttribute['quoted'] = static::SingleQuoted;
        }
        /* Start/End Tag Tokens */
        public function selfClosing() {
            return $this->_selfClosing;
        }
        public function setSelfClosing() {
            $this->_selfClosing = true;
        }
        public function beginStartTag($character) {
            $this->setType(static::StartTag);
            $this->_selfClosing = false;
            $this->_currentAttribute = 0;
            $this->_attributes = array();
            $this->_data .= $character;
        }
        public function beginEndTag($character) {
            $this->setType(static::EndTag);
            $this->_selfClosing = false;
            $this->_currentAttribute = 0;
            $this->_attributes = array();
            $this->_data .= $character;
        }
        public function addNewAttribute() {
            // m_attributes.grow(m_attributes.size() + 1);
            // m_currentAttribute = &m_attributes.last();
            $_default = array(
                'name' => '',
                'value' => '',
                'quoted' => false,
            );
            unset($this->_currentAttribute);
            $this->_currentAttribute = $_default;
            $this->_attributes[] = & $this->_currentAttribute;
        }
        public function beginAttributeName($offset) {
            // m_currentAttribute->nameRange.start = offset - m_baseOffset;
            // $this->_currentAttribute['nameRange']['start'] = $offset;
        }
        public function endAttributeName($offset) {
            // int index = offset - m_baseOffset;
            // m_currentAttribute->nameRange.end = index;
            // m_currentAttribute->valueRange.start = index;
            // m_currentAttribute->valueRange.end = index;
            // $this->_currentAttribute['nameRange']['end'] = $offset;
            // $this->_currentAttribute['valueRange']['start'] = $offset;
            // $this->_currentAttribute['valueRange']['end'] = $offset;
        }
        public function beginAttributeValue($offset) {
            // m_currentAttribute->valueRange.start = offset - m_baseOffset;
            // #ifndef NDEBUG
            // m_currentAttribute->valueRange.end = 0;
            // #endif
            // $this->_currentAttribute['valueRange']['start'] = $offset;
        }
        public function endAttributeValue($offset) {
            // m_currentAttribute->valueRange.end = offset - m_baseOffset;
            // $this->_currentAttribute['valueRange']['end'] = $offset;
        }
        public function appendToAttributeName($character) {
            // FIXME: We should be able to add the following ASSERT once we fix
            // https://bugs.webkit.org/show_bug.cgi?id=62971
            //   ASSERT(m_currentAttribute->nameRange.start);
            // m_currentAttribute->name.append(character);
            $this->_currentAttribute['name'] .= $character;
        }
        public function appendToAttributeValue($character) {
            // FIXME: We should be able to add the following ASSERT once we fix
            // m_currentAttribute->value.append(character);
            $this->_currentAttribute['value'] .= $character;
        }
        /* DOCTYPE Tokens */
        public function  forceQuirks() {
            // return m_doctypeData->m_forceQuirks;
            return $this->_doctypeData['forceQuirks'];
        }
        public function  setForceQuirks() {
            // m_doctypeData->m_forceQuirks = true;
            $this->_doctypeData['forceQuirks'] = true;
        }
        protected function _beginDOCTYPE() {
            $this->_type = static::DOCTYPE;
            // m_doctypeData = adoptPtr(new DoctypeData);
        }
        public function beginDOCTYPE($character = null) {
            $this->_beginDOCTYPE();
            if ($character) {
                $this->_data .= $character;
            }
        }
        public function setPublicIdentifierToEmptyString() {
            // m_doctypeData->m_hasPublicIdentifier = true;
            // m_doctypeData->m_publicIdentifier.clear();
            $this->_doctypeData['hasPublicIdentifier'] = true;
            $this->_doctypeData['publicIdentifier'] = '';
        }
        public function setSystemIdentifierToEmptyString() {
            // m_doctypeData->m_hasSystemIdentifier = true;
            // m_doctypeData->m_systemIdentifier.clear();
            $this->_doctypeData['hasSystemIdentifier'] = true;
            $this->_doctypeData['systemIdentifier'] = '';
        }
        public function appendToPublicIdentifier($character) {
            // m_doctypeData->m_publicIdentifier.append(character);
            $this->_doctypeData['publicIdentifier'] .= $character;
        }
        public function appendToSystemIdentifier($character) {
            // m_doctypeData->m_systemIdentifier.append(character);
            $this->_doctypeData['systemIdentifier'] .= $character;
        }
    }

    class HTMLNames {
        // Tags
        const aTag = 'a';
        const abbrTag = 'abbr';
        const acronymTag = 'acronym';
        const addressTag = 'address';
        const appletTag = 'applet';
        const areaTag = 'area';
        const articleTag = 'article';
        const asideTag = 'aside';
        const audioTag = 'audio';
        const bTag = 'b';
        const baseTag = 'base';
        const basefontTag = 'basefont';
        const bdoTag = 'bdo';
        const bgsoundTag = 'bgsound';
        const bigTag = 'big';
        const blockquoteTag = 'blockquote';
        const bodyTag = 'body';
        const brTag = 'br';
        const buttonTag = 'button';
        const canvasTag = 'canvas';
        const captionTag = 'caption';
        const centerTag = 'center';
        const citeTag = 'cite';
        const codeTag = 'code';
        const colTag = 'col';
        const colgroupTag = 'colgroup';
        const commandTag = 'command';
        const datalistTag = 'datalist';
        const ddTag = 'dd';
        const delTag = 'del';
        const detailsTag = 'details';
        const dfnTag = 'dfn';
        const dirTag = 'dir';
        const divTag = 'div';
        const dlTag = 'dl';
        const dtTag = 'dt';
        const emTag = 'em';
        const embedTag = 'embed';
        const fieldsetTag = 'fieldset';
        const figcaptionTag = 'figcaption';
        const figureTag = 'figure';
        const fontTag = 'font';
        const footerTag = 'footer';
        const formTag = 'form';
        const frameTag = 'frame';
        const framesetTag = 'frameset';
        const h1Tag = 'h1';
        const h2Tag = 'h2';
        const h3Tag = 'h3';
        const h4Tag = 'h4';
        const h5Tag = 'h5';
        const h6Tag = 'h6';
        const headTag = 'head';
        const headerTag = 'header';
        const hgroupTag = 'hgroup';
        const hrTag = 'hr';
        const htmlTag = 'html';
        const iTag = 'i';
        const iframeTag = 'iframe';
        const imageTag = 'image';
        const imgTag = 'img';
        const inputTag = 'input';
        const insTag = 'ins';
        const isindexTag = 'isindex';
        const kbdTag = 'kbd';
        const keygenTag = 'keygen';
        const labelTag = 'label';
        const layerTag = 'layer';
        const legendTag = 'legend';
        const liTag = 'li';
        const linkTag = 'link';
        const listingTag = 'listing';
        const mapTag = 'map';
        const markTag = 'mark';
        const marqueeTag = 'marquee';
        const menuTag = 'menu';
        const metaTag = 'meta';
        const meterTag = 'meter';
        const navTag = 'nav';
        const nobrTag = 'nobr';
        const noembedTag = 'noembed';
        const noframesTag = 'noframes';
        const nolayerTag = 'nolayer';
        const noscriptTag = 'noscript';
        const objectTag = 'object';
        const olTag = 'ol';
        const optgroupTag = 'optgroup';
        const optionTag = 'option';
        const outputTag = 'output';
        const pTag = 'p';
        const paramTag = 'param';
        const plaintextTag = 'plaintext';
        const preTag = 'pre';
        const progressTag = 'progress';
        const qTag = 'q';
        const rpTag = 'rp';
        const rtTag = 'rt';
        const rubyTag = 'ruby';
        const sTag = 's';
        const sampTag = 'samp';
        const scriptTag = 'script';
        const sectionTag = 'section';
        const selectTag = 'select';
        const smallTag = 'small';
        const sourceTag = 'source';
        const spanTag = 'span';
        const strikeTag = 'strike';
        const strongTag = 'strong';
        const styleTag = 'style';
        const subTag = 'sub';
        const summaryTag = 'summary';
        const supTag = 'sup';
        const tableTag = 'table';
        const tbodyTag = 'tbody';
        const tdTag = 'td';
        const textareaTag = 'textarea';
        const tfootTag = 'tfoot';
        const thTag = 'th';
        const theadTag = 'thead';
        const titleTag = 'title';
        const trTag = 'tr';
        const trackTag = 'track';
        const ttTag = 'tt';
        const uTag = 'u';
        const ulTag = 'ul';
        const varTag = 'var';
        const videoTag = 'video';
        const wbrTag = 'wbr';
        const xmpTag = 'xmp';
        // Attributes
        const abbrAttr = 'abbr';
        const acceptAttr = 'accept';
        const accept_charsetAttr = 'accept-charset';
        const accesskeyAttr = 'accesskey';
        const actionAttr = 'action';
        const alignAttr = 'align';
        const alinkAttr = 'alink';
        const altAttr = 'alt';
        const archiveAttr = 'archive';
        const aria_activedescendantAttr = 'aria-activedescendant';
        const aria_atomicAttr = 'aria-atomic';
        const aria_busyAttr = 'aria-busy';
        const aria_checkedAttr = 'aria-checked';
        const aria_controlsAttr = 'aria-controls';
        const aria_describedbyAttr = 'aria-describedby';
        const aria_disabledAttr = 'aria-disabled';
        const aria_dropeffectAttr = 'aria-dropeffect';
        const aria_expandedAttr = 'aria-expanded';
        const aria_flowtoAttr = 'aria-flowto';
        const aria_grabbedAttr = 'aria-grabbed';
        const aria_haspopupAttr = 'aria-haspopup';
        const aria_helpAttr = 'aria-help';
        const aria_hiddenAttr = 'aria-hidden';
        const aria_invalidAttr = 'aria-invalid';
        const aria_labelAttr = 'aria-label';
        const aria_labeledbyAttr = 'aria-labeledby';
        const aria_labelledbyAttr = 'aria-labelledby';
        const aria_levelAttr = 'aria-level';
        const aria_liveAttr = 'aria-live';
        const aria_multilineAttr = 'aria-multiline';
        const aria_multiselectableAttr = 'aria-multiselectable';
        const aria_orientationAttr = 'aria-orientation';
        const aria_ownsAttr = 'aria-owns';
        const aria_pressedAttr = 'aria-pressed';
        const aria_readonlyAttr = 'aria-readonly';
        const aria_relevantAttr = 'aria-relevant';
        const aria_requiredAttr = 'aria-required';
        const aria_selectedAttr = 'aria-selected';
        const aria_sortAttr = 'aria-sort';
        const aria_valuemaxAttr = 'aria-valuemax';
        const aria_valueminAttr = 'aria-valuemin';
        const aria_valuenowAttr = 'aria-valuenow';
        const aria_valuetextAttr = 'aria-valuetext';
        const asyncAttr = 'async';
        const autocompleteAttr = 'autocomplete';
        const autofocusAttr = 'autofocus';
        const autoplayAttr = 'autoplay';
        const autosaveAttr = 'autosave';
        const axisAttr = 'axis';
        const backgroundAttr = 'background';
        const behaviorAttr = 'behavior';
        const bgcolorAttr = 'bgcolor';
        const bgpropertiesAttr = 'bgproperties';
        const borderAttr = 'border';
        const bordercolorAttr = 'bordercolor';
        const cellborderAttr = 'cellborder';
        const cellpaddingAttr = 'cellpadding';
        const cellspacingAttr = 'cellspacing';
        const challengeAttr = 'challenge';
        const charAttr = 'char';
        const charoffAttr = 'charoff';
        const charsetAttr = 'charset';
        const checkedAttr = 'checked';
        const citeAttr = 'cite';
        const classAttr = 'class';
        const classidAttr = 'classid';
        const clearAttr = 'clear';
        const codeAttr = 'code';
        const codebaseAttr = 'codebase';
        const codetypeAttr = 'codetype';
        const colorAttr = 'color';
        const colsAttr = 'cols';
        const colspanAttr = 'colspan';
        const compactAttr = 'compact';
        const compositeAttr = 'composite';
        const contentAttr = 'content';
        const contenteditableAttr = 'contenteditable';
        const controlsAttr = 'controls';
        const coordsAttr = 'coords';
        const dataAttr = 'data';
        const datetimeAttr = 'datetime';
        const declareAttr = 'declare';
        const defaultAttr = 'default';
        const deferAttr = 'defer';
        const dirAttr = 'dir';
        const directionAttr = 'direction';
        const disabledAttr = 'disabled';
        const draggableAttr = 'draggable';
        const enctypeAttr = 'enctype';
        const endAttr = 'end';
        const eventAttr = 'event';
        const expandedAttr = 'expanded';
        const faceAttr = 'face';
        const focusedAttr = 'focused';
        const forAttr = 'for';
        const formAttr = 'form';
        const formactionAttr = 'formaction';
        const formenctypeAttr = 'formenctype';
        const formmethodAttr = 'formmethod';
        const formnovalidateAttr = 'formnovalidate';
        const formtargetAttr = 'formtarget';
        const frameAttr = 'frame';
        const frameborderAttr = 'frameborder';
        const headersAttr = 'headers';
        const heightAttr = 'height';
        const hiddenAttr = 'hidden';
        const highAttr = 'high';
        const hrefAttr = 'href';
        const hreflangAttr = 'hreflang';
        const hspaceAttr = 'hspace';
        const http_equivAttr = 'http-equiv';
        const idAttr = 'id';
        const incrementalAttr = 'incremental';
        const indeterminateAttr = 'indeterminate';
        const ismapAttr = 'ismap';
        const keytypeAttr = 'keytype';
        const kindAttr = 'kind';
        const labelAttr = 'label';
        const langAttr = 'lang';
        const languageAttr = 'language';
        const leftmarginAttr = 'leftmargin';
        const linkAttr = 'link';
        const listAttr = 'list';
        const longdescAttr = 'longdesc';
        const loopAttr = 'loop';
        const loopendAttr = 'loopend';
        const loopstartAttr = 'loopstart';
        const lowAttr = 'low';
        const lowsrcAttr = 'lowsrc';
        const manifestAttr = 'manifest';
        const marginheightAttr = 'marginheight';
        const marginwidthAttr = 'marginwidth';
        const maxAttr = 'max';
        const maxlengthAttr = 'maxlength';
        const mayscriptAttr = 'mayscript';
        const mediaAttr = 'media';
        const methodAttr = 'method';
        const minAttr = 'min';
        const multipleAttr = 'multiple';
        const nameAttr = 'name';
        const nohrefAttr = 'nohref';
        const noresizeAttr = 'noresize';
        const noshadeAttr = 'noshade';
        const novalidateAttr = 'novalidate';
        const nowrapAttr = 'nowrap';
        const objectAttr = 'object';
        const onabortAttr = 'onabort';
        const onbeforecopyAttr = 'onbeforecopy';
        const onbeforecutAttr = 'onbeforecut';
        const onbeforeloadAttr = 'onbeforeload';
        const onbeforepasteAttr = 'onbeforepaste';
        const onbeforeprocessAttr = 'onbeforeprocess';
        const onbeforeunloadAttr = 'onbeforeunload';
        const onblurAttr = 'onblur';
        const oncanplayAttr = 'oncanplay';
        const oncanplaythroughAttr = 'oncanplaythrough';
        const onchangeAttr = 'onchange';
        const onclickAttr = 'onclick';
        const oncontextmenuAttr = 'oncontextmenu';
        const oncopyAttr = 'oncopy';
        const oncutAttr = 'oncut';
        const ondblclickAttr = 'ondblclick';
        const ondragAttr = 'ondrag';
        const ondragendAttr = 'ondragend';
        const ondragenterAttr = 'ondragenter';
        const ondragleaveAttr = 'ondragleave';
        const ondragoverAttr = 'ondragover';
        const ondragstartAttr = 'ondragstart';
        const ondropAttr = 'ondrop';
        const ondurationchangeAttr = 'ondurationchange';
        const onemptiedAttr = 'onemptied';
        const onendedAttr = 'onended';
        const onerrorAttr = 'onerror';
        const onfocusAttr = 'onfocus';
        const onfocusinAttr = 'onfocusin';
        const onfocusoutAttr = 'onfocusout';
        const onhashchangeAttr = 'onhashchange';
        const oninputAttr = 'oninput';
        const oninvalidAttr = 'oninvalid';
        const onkeydownAttr = 'onkeydown';
        const onkeypressAttr = 'onkeypress';
        const onkeyupAttr = 'onkeyup';
        const onloadAttr = 'onload';
        const onloadeddataAttr = 'onloadeddata';
        const onloadedmetadataAttr = 'onloadedmetadata';
        const onloadstartAttr = 'onloadstart';
        const onmousedownAttr = 'onmousedown';
        const onmousemoveAttr = 'onmousemove';
        const onmouseoutAttr = 'onmouseout';
        const onmouseoverAttr = 'onmouseover';
        const onmouseupAttr = 'onmouseup';
        const onmousewheelAttr = 'onmousewheel';
        const onofflineAttr = 'onoffline';
        const ononlineAttr = 'ononline';
        const onorientationchangeAttr = 'onorientationchange';
        const onpagehideAttr = 'onpagehide';
        const onpageshowAttr = 'onpageshow';
        const onpasteAttr = 'onpaste';
        const onpauseAttr = 'onpause';
        const onplayAttr = 'onplay';
        const onplayingAttr = 'onplaying';
        const onpopstateAttr = 'onpopstate';
        const onprogressAttr = 'onprogress';
        const onratechangeAttr = 'onratechange';
        const onresetAttr = 'onreset';
        const onresizeAttr = 'onresize';
        const onscrollAttr = 'onscroll';
        const onsearchAttr = 'onsearch';
        const onseekedAttr = 'onseeked';
        const onseekingAttr = 'onseeking';
        const onselectAttr = 'onselect';
        const onselectionchangeAttr = 'onselectionchange';
        const onselectstartAttr = 'onselectstart';
        const onstalledAttr = 'onstalled';
        const onstorageAttr = 'onstorage';
        const onsubmitAttr = 'onsubmit';
        const onsuspendAttr = 'onsuspend';
        const ontimeupdateAttr = 'ontimeupdate';
        const ontouchcancelAttr = 'ontouchcancel';
        const ontouchendAttr = 'ontouchend';
        const ontouchmoveAttr = 'ontouchmove';
        const ontouchstartAttr = 'ontouchstart';
        const onunloadAttr = 'onunload';
        const onvolumechangeAttr = 'onvolumechange';
        const onwaitingAttr = 'onwaiting';
        const onwebkitanimationendAttr = 'onwebkitanimationend';
        const onwebkitanimationiterationAttr = 'onwebkitanimationiteration';
        const onwebkitanimationstartAttr = 'onwebkitanimationstart';
        const onwebkitbeginfullscreenAttr = 'onwebkitbeginfullscreen';
        const onwebkitendfullscreenAttr = 'onwebkitendfullscreen';
        const onwebkitfullscreenchangeAttr = 'onwebkitfullscreenchange';
        const onwebkitspeechchangeAttr = 'onwebkitspeechchange';
        const onwebkittransitionendAttr = 'onwebkittransitionend';
        const openAttr = 'open';
        const optimumAttr = 'optimum';
        const patternAttr = 'pattern';
        const pingAttr = 'ping';
        const placeholderAttr = 'placeholder';
        const playcountAttr = 'playcount';
        const pluginspageAttr = 'pluginspage';
        const pluginurlAttr = 'pluginurl';
        const posterAttr = 'poster';
        const precisionAttr = 'precision';
        const preloadAttr = 'preload';
        const primaryAttr = 'primary';
        const profileAttr = 'profile';
        const progressAttr = 'progress';
        const promptAttr = 'prompt';
        const readonlyAttr = 'readonly';
        const relAttr = 'rel';
        const requiredAttr = 'required';
        const resultsAttr = 'results';
        const revAttr = 'rev';
        const roleAttr = 'role';
        const rowsAttr = 'rows';
        const rowspanAttr = 'rowspan';
        const rulesAttr = 'rules';
        const sandboxAttr = 'sandbox';
        const schemeAttr = 'scheme';
        const scopeAttr = 'scope';
        const scrollamountAttr = 'scrollamount';
        const scrolldelayAttr = 'scrolldelay';
        const scrollingAttr = 'scrolling';
        const selectedAttr = 'selected';
        const shapeAttr = 'shape';
        const sizeAttr = 'size';
        const sortableAttr = 'sortable';
        const sortdirectionAttr = 'sortdirection';
        const spanAttr = 'span';
        const spellcheckAttr = 'spellcheck';
        const srcAttr = 'src';
        const srclangAttr = 'srclang';
        const standbyAttr = 'standby';
        const startAttr = 'start';
        const stepAttr = 'step';
        const styleAttr = 'style';
        const summaryAttr = 'summary';
        const tabindexAttr = 'tabindex';
        const tableborderAttr = 'tableborder';
        const targetAttr = 'target';
        const textAttr = 'text';
        const titleAttr = 'title';
        const topAttr = 'top';
        const topmarginAttr = 'topmargin';
        const truespeedAttr = 'truespeed';
        const typeAttr = 'type';
        const usemapAttr = 'usemap';
        const valignAttr = 'valign';
        const valueAttr = 'value';
        const valuetypeAttr = 'valuetype';
        const versionAttr = 'version';
        const viewsourceAttr = 'viewsource';
        const vlinkAttr = 'vlink';
        const vspaceAttr = 'vspace';
        const webkitallowfullscreenAttr = 'webkitallowfullscreen';
        const webkitdirectoryAttr = 'webkitdirectory';
        const webkitgrammarAttr = 'x-webkit-grammar';
        const webkitspeechAttr = 'x-webkit-speech';
        const widthAttr = 'width';
        const wrapAttr = 'wrap';
        public static function getHTMLTags() {
            return array(
                static::aTag => static::aTag,
                static::abbrTag => static::abbrTag,
                static::acronymTag => static::acronymTag,
                static::addressTag => static::addressTag,
                static::appletTag => static::appletTag,
                static::areaTag => static::areaTag,
                static::articleTag => static::articleTag,
                static::asideTag => static::asideTag,
                static::audioTag => static::audioTag,
                static::bTag => static::bTag,
                static::baseTag => static::baseTag,
                static::basefontTag => static::basefontTag,
                static::bdoTag => static::bdoTag,
                static::bgsoundTag => static::bgsoundTag,
                static::bigTag => static::bigTag,
                static::blockquoteTag => static::blockquoteTag,
                static::bodyTag => static::bodyTag,
                static::brTag => static::brTag,
                static::buttonTag => static::buttonTag,
                static::canvasTag => static::canvasTag,
                static::captionTag => static::captionTag,
                static::centerTag => static::centerTag,
                static::citeTag => static::citeTag,
                static::codeTag => static::codeTag,
                static::colTag => static::colTag,
                static::colgroupTag => static::colgroupTag,
                static::commandTag => static::commandTag,
                static::datalistTag => static::datalistTag,
                static::ddTag => static::ddTag,
                static::delTag => static::delTag,
                static::detailsTag => static::detailsTag,
                static::dfnTag => static::dfnTag,
                static::dirTag => static::dirTag,
                static::divTag => static::divTag,
                static::dlTag => static::dlTag,
                static::dtTag => static::dtTag,
                static::emTag => static::emTag,
                static::embedTag => static::embedTag,
                static::fieldsetTag => static::fieldsetTag,
                static::figcaptionTag => static::figcaptionTag,
                static::figureTag => static::figureTag,
                static::fontTag => static::fontTag,
                static::footerTag => static::footerTag,
                static::formTag => static::formTag,
                static::frameTag => static::frameTag,
                static::framesetTag => static::framesetTag,
                static::h1Tag => static::h1Tag,
                static::h2Tag => static::h2Tag,
                static::h3Tag => static::h3Tag,
                static::h4Tag => static::h4Tag,
                static::h5Tag => static::h5Tag,
                static::h6Tag => static::h6Tag,
                static::headTag => static::headTag,
                static::headerTag => static::headerTag,
                static::hgroupTag => static::hgroupTag,
                static::hrTag => static::hrTag,
                static::htmlTag => static::htmlTag,
                static::iTag => static::iTag,
                static::iframeTag => static::iframeTag,
                static::imageTag => static::imageTag,
                static::imgTag => static::imgTag,
                static::inputTag => static::inputTag,
                static::insTag => static::insTag,
                static::isindexTag => static::isindexTag,
                static::kbdTag => static::kbdTag,
                static::keygenTag => static::keygenTag,
                static::labelTag => static::labelTag,
                static::layerTag => static::layerTag,
                static::legendTag => static::legendTag,
                static::liTag => static::liTag,
                static::linkTag => static::linkTag,
                static::listingTag => static::listingTag,
                static::mapTag => static::mapTag,
                static::markTag => static::markTag,
                static::marqueeTag => static::marqueeTag,
                static::menuTag => static::menuTag,
                static::metaTag => static::metaTag,
                static::meterTag => static::meterTag,
                static::navTag => static::navTag,
                static::nobrTag => static::nobrTag,
                static::noembedTag => static::noembedTag,
                static::noframesTag => static::noframesTag,
                static::nolayerTag => static::nolayerTag,
                static::noscriptTag => static::noscriptTag,
                static::objectTag => static::objectTag,
                static::olTag => static::olTag,
                static::optgroupTag => static::optgroupTag,
                static::optionTag => static::optionTag,
                static::outputTag => static::outputTag,
                static::pTag => static::pTag,
                static::paramTag => static::paramTag,
                static::plaintextTag => static::plaintextTag,
                static::preTag => static::preTag,
                static::progressTag => static::progressTag,
                static::qTag => static::qTag,
                static::rpTag => static::rpTag,
                static::rtTag => static::rtTag,
                static::rubyTag => static::rubyTag,
                static::sTag => static::sTag,
                static::sampTag => static::sampTag,
                static::scriptTag => static::scriptTag,
                static::sectionTag => static::sectionTag,
                static::selectTag => static::selectTag,
                static::smallTag => static::smallTag,
                static::sourceTag => static::sourceTag,
                static::spanTag => static::spanTag,
                static::strikeTag => static::strikeTag,
                static::strongTag => static::strongTag,
                static::styleTag => static::styleTag,
                static::subTag => static::subTag,
                static::summaryTag => static::summaryTag,
                static::supTag => static::supTag,
                static::tableTag => static::tableTag,
                static::tbodyTag => static::tbodyTag,
                static::tdTag => static::tdTag,
                static::textareaTag => static::textareaTag,
                static::tfootTag => static::tfootTag,
                static::thTag => static::thTag,
                static::theadTag => static::theadTag,
                static::titleTag => static::titleTag,
                static::trTag => static::trTag,
                static::trackTag => static::trackTag,
                static::ttTag => static::ttTag,
                static::uTag => static::uTag,
                static::ulTag => static::ulTag,
                static::varTag => static::varTag,
                static::videoTag => static::videoTag,
                static::wbrTag => static::wbrTag,
                static::xmpTag => static::xmpTag,
            );
        }
        public static function getHTMLAttrs() {
            return array(
                static::abbrAttr => static::abbrAttr,
                static::acceptAttr => static::acceptAttr,
                static::accept_charsetAttr => static::accept_charsetAttr,
                static::accesskeyAttr => static::accesskeyAttr,
                static::actionAttr => static::actionAttr,
                static::alignAttr => static::alignAttr,
                static::alinkAttr => static::alinkAttr,
                static::altAttr => static::altAttr,
                static::archiveAttr => static::archiveAttr,
                static::aria_activedescendantAttr => static::aria_activedescendantAttr,
                static::aria_atomicAttr => static::aria_atomicAttr,
                static::aria_busyAttr => static::aria_busyAttr,
                static::aria_checkedAttr => static::aria_checkedAttr,
                static::aria_controlsAttr => static::aria_controlsAttr,
                static::aria_describedbyAttr => static::aria_describedbyAttr,
                static::aria_disabledAttr => static::aria_disabledAttr,
                static::aria_dropeffectAttr => static::aria_dropeffectAttr,
                static::aria_expandedAttr => static::aria_expandedAttr,
                static::aria_flowtoAttr => static::aria_flowtoAttr,
                static::aria_grabbedAttr => static::aria_grabbedAttr,
                static::aria_haspopupAttr => static::aria_haspopupAttr,
                static::aria_helpAttr => static::aria_helpAttr,
                static::aria_hiddenAttr => static::aria_hiddenAttr,
                static::aria_invalidAttr => static::aria_invalidAttr,
                static::aria_labelAttr => static::aria_labelAttr,
                static::aria_labeledbyAttr => static::aria_labeledbyAttr,
                static::aria_labelledbyAttr => static::aria_labelledbyAttr,
                static::aria_levelAttr => static::aria_levelAttr,
                static::aria_liveAttr => static::aria_liveAttr,
                static::aria_multilineAttr => static::aria_multilineAttr,
                static::aria_multiselectableAttr => static::aria_multiselectableAttr,
                static::aria_orientationAttr => static::aria_orientationAttr,
                static::aria_ownsAttr => static::aria_ownsAttr,
                static::aria_pressedAttr => static::aria_pressedAttr,
                static::aria_readonlyAttr => static::aria_readonlyAttr,
                static::aria_relevantAttr => static::aria_relevantAttr,
                static::aria_requiredAttr => static::aria_requiredAttr,
                static::aria_selectedAttr => static::aria_selectedAttr,
                static::aria_sortAttr => static::aria_sortAttr,
                static::aria_valuemaxAttr => static::aria_valuemaxAttr,
                static::aria_valueminAttr => static::aria_valueminAttr,
                static::aria_valuenowAttr => static::aria_valuenowAttr,
                static::aria_valuetextAttr => static::aria_valuetextAttr,
                static::asyncAttr => static::asyncAttr,
                static::autocompleteAttr => static::autocompleteAttr,
                static::autofocusAttr => static::autofocusAttr,
                static::autoplayAttr => static::autoplayAttr,
                static::autosaveAttr => static::autosaveAttr,
                static::axisAttr => static::axisAttr,
                static::backgroundAttr => static::backgroundAttr,
                static::behaviorAttr => static::behaviorAttr,
                static::bgcolorAttr => static::bgcolorAttr,
                static::bgpropertiesAttr => static::bgpropertiesAttr,
                static::borderAttr => static::borderAttr,
                static::bordercolorAttr => static::bordercolorAttr,
                static::cellborderAttr => static::cellborderAttr,
                static::cellpaddingAttr => static::cellpaddingAttr,
                static::cellspacingAttr => static::cellspacingAttr,
                static::challengeAttr => static::challengeAttr,
                static::charAttr => static::charAttr,
                static::charoffAttr => static::charoffAttr,
                static::charsetAttr => static::charsetAttr,
                static::checkedAttr => static::checkedAttr,
                static::citeAttr => static::citeAttr,
                static::classAttr => static::classAttr,
                static::classidAttr => static::classidAttr,
                static::clearAttr => static::clearAttr,
                static::codeAttr => static::codeAttr,
                static::codebaseAttr => static::codebaseAttr,
                static::codetypeAttr => static::codetypeAttr,
                static::colorAttr => static::colorAttr,
                static::colsAttr => static::colsAttr,
                static::colspanAttr => static::colspanAttr,
                static::compactAttr => static::compactAttr,
                static::compositeAttr => static::compositeAttr,
                static::contentAttr => static::contentAttr,
                static::contenteditableAttr => static::contenteditableAttr,
                static::controlsAttr => static::controlsAttr,
                static::coordsAttr => static::coordsAttr,
                static::dataAttr => static::dataAttr,
                static::datetimeAttr => static::datetimeAttr,
                static::declareAttr => static::declareAttr,
                static::defaultAttr => static::defaultAttr,
                static::deferAttr => static::deferAttr,
                static::dirAttr => static::dirAttr,
                static::directionAttr => static::directionAttr,
                static::disabledAttr => static::disabledAttr,
                static::draggableAttr => static::draggableAttr,
                static::enctypeAttr => static::enctypeAttr,
                static::endAttr => static::endAttr,
                static::eventAttr => static::eventAttr,
                static::expandedAttr => static::expandedAttr,
                static::faceAttr => static::faceAttr,
                static::focusedAttr => static::focusedAttr,
                static::forAttr => static::forAttr,
                static::formAttr => static::formAttr,
                static::formactionAttr => static::formactionAttr,
                static::formenctypeAttr => static::formenctypeAttr,
                static::formmethodAttr => static::formmethodAttr,
                static::formnovalidateAttr => static::formnovalidateAttr,
                static::formtargetAttr => static::formtargetAttr,
                static::frameAttr => static::frameAttr,
                static::frameborderAttr => static::frameborderAttr,
                static::headersAttr => static::headersAttr,
                static::heightAttr => static::heightAttr,
                static::hiddenAttr => static::hiddenAttr,
                static::highAttr => static::highAttr,
                static::hrefAttr => static::hrefAttr,
                static::hreflangAttr => static::hreflangAttr,
                static::hspaceAttr => static::hspaceAttr,
                static::http_equivAttr => static::http_equivAttr,
                static::idAttr => static::idAttr,
                static::incrementalAttr => static::incrementalAttr,
                static::indeterminateAttr => static::indeterminateAttr,
                static::ismapAttr => static::ismapAttr,
                static::keytypeAttr => static::keytypeAttr,
                static::kindAttr => static::kindAttr,
                static::labelAttr => static::labelAttr,
                static::langAttr => static::langAttr,
                static::languageAttr => static::languageAttr,
                static::leftmarginAttr => static::leftmarginAttr,
                static::linkAttr => static::linkAttr,
                static::listAttr => static::listAttr,
                static::longdescAttr => static::longdescAttr,
                static::loopAttr => static::loopAttr,
                static::loopendAttr => static::loopendAttr,
                static::loopstartAttr => static::loopstartAttr,
                static::lowAttr => static::lowAttr,
                static::lowsrcAttr => static::lowsrcAttr,
                static::manifestAttr => static::manifestAttr,
                static::marginheightAttr => static::marginheightAttr,
                static::marginwidthAttr => static::marginwidthAttr,
                static::maxAttr => static::maxAttr,
                static::maxlengthAttr => static::maxlengthAttr,
                static::mayscriptAttr => static::mayscriptAttr,
                static::mediaAttr => static::mediaAttr,
                static::methodAttr => static::methodAttr,
                static::minAttr => static::minAttr,
                static::multipleAttr => static::multipleAttr,
                static::nameAttr => static::nameAttr,
                static::nohrefAttr => static::nohrefAttr,
                static::noresizeAttr => static::noresizeAttr,
                static::noshadeAttr => static::noshadeAttr,
                static::novalidateAttr => static::novalidateAttr,
                static::nowrapAttr => static::nowrapAttr,
                static::objectAttr => static::objectAttr,
                static::onabortAttr => static::onabortAttr,
                static::onbeforecopyAttr => static::onbeforecopyAttr,
                static::onbeforecutAttr => static::onbeforecutAttr,
                static::onbeforeloadAttr => static::onbeforeloadAttr,
                static::onbeforepasteAttr => static::onbeforepasteAttr,
                static::onbeforeprocessAttr => static::onbeforeprocessAttr,
                static::onbeforeunloadAttr => static::onbeforeunloadAttr,
                static::onblurAttr => static::onblurAttr,
                static::oncanplayAttr => static::oncanplayAttr,
                static::oncanplaythroughAttr => static::oncanplaythroughAttr,
                static::onchangeAttr => static::onchangeAttr,
                static::onclickAttr => static::onclickAttr,
                static::oncontextmenuAttr => static::oncontextmenuAttr,
                static::oncopyAttr => static::oncopyAttr,
                static::oncutAttr => static::oncutAttr,
                static::ondblclickAttr => static::ondblclickAttr,
                static::ondragAttr => static::ondragAttr,
                static::ondragendAttr => static::ondragendAttr,
                static::ondragenterAttr => static::ondragenterAttr,
                static::ondragleaveAttr => static::ondragleaveAttr,
                static::ondragoverAttr => static::ondragoverAttr,
                static::ondragstartAttr => static::ondragstartAttr,
                static::ondropAttr => static::ondropAttr,
                static::ondurationchangeAttr => static::ondurationchangeAttr,
                static::onemptiedAttr => static::onemptiedAttr,
                static::onendedAttr => static::onendedAttr,
                static::onerrorAttr => static::onerrorAttr,
                static::onfocusAttr => static::onfocusAttr,
                static::onfocusinAttr => static::onfocusinAttr,
                static::onfocusoutAttr => static::onfocusoutAttr,
                static::onhashchangeAttr => static::onhashchangeAttr,
                static::oninputAttr => static::oninputAttr,
                static::oninvalidAttr => static::oninvalidAttr,
                static::onkeydownAttr => static::onkeydownAttr,
                static::onkeypressAttr => static::onkeypressAttr,
                static::onkeyupAttr => static::onkeyupAttr,
                static::onloadAttr => static::onloadAttr,
                static::onloadeddataAttr => static::onloadeddataAttr,
                static::onloadedmetadataAttr => static::onloadedmetadataAttr,
                static::onloadstartAttr => static::onloadstartAttr,
                static::onmousedownAttr => static::onmousedownAttr,
                static::onmousemoveAttr => static::onmousemoveAttr,
                static::onmouseoutAttr => static::onmouseoutAttr,
                static::onmouseoverAttr => static::onmouseoverAttr,
                static::onmouseupAttr => static::onmouseupAttr,
                static::onmousewheelAttr => static::onmousewheelAttr,
                static::onofflineAttr => static::onofflineAttr,
                static::ononlineAttr => static::ononlineAttr,
                static::onorientationchangeAttr => static::onorientationchangeAttr,
                static::onpagehideAttr => static::onpagehideAttr,
                static::onpageshowAttr => static::onpageshowAttr,
                static::onpasteAttr => static::onpasteAttr,
                static::onpauseAttr => static::onpauseAttr,
                static::onplayAttr => static::onplayAttr,
                static::onplayingAttr => static::onplayingAttr,
                static::onpopstateAttr => static::onpopstateAttr,
                static::onprogressAttr => static::onprogressAttr,
                static::onratechangeAttr => static::onratechangeAttr,
                static::onresetAttr => static::onresetAttr,
                static::onresizeAttr => static::onresizeAttr,
                static::onscrollAttr => static::onscrollAttr,
                static::onsearchAttr => static::onsearchAttr,
                static::onseekedAttr => static::onseekedAttr,
                static::onseekingAttr => static::onseekingAttr,
                static::onselectAttr => static::onselectAttr,
                static::onselectionchangeAttr => static::onselectionchangeAttr,
                static::onselectstartAttr => static::onselectstartAttr,
                static::onstalledAttr => static::onstalledAttr,
                static::onstorageAttr => static::onstorageAttr,
                static::onsubmitAttr => static::onsubmitAttr,
                static::onsuspendAttr => static::onsuspendAttr,
                static::ontimeupdateAttr => static::ontimeupdateAttr,
                static::ontouchcancelAttr => static::ontouchcancelAttr,
                static::ontouchendAttr => static::ontouchendAttr,
                static::ontouchmoveAttr => static::ontouchmoveAttr,
                static::ontouchstartAttr => static::ontouchstartAttr,
                static::onunloadAttr => static::onunloadAttr,
                static::onvolumechangeAttr => static::onvolumechangeAttr,
                static::onwaitingAttr => static::onwaitingAttr,
                static::onwebkitanimationendAttr => static::onwebkitanimationendAttr,
                static::onwebkitanimationiterationAttr => static::onwebkitanimationiterationAttr,
                static::onwebkitanimationstartAttr => static::onwebkitanimationstartAttr,
                static::onwebkitbeginfullscreenAttr => static::onwebkitbeginfullscreenAttr,
                static::onwebkitendfullscreenAttr => static::onwebkitendfullscreenAttr,
                static::onwebkitfullscreenchangeAttr => static::onwebkitfullscreenchangeAttr,
                static::onwebkitspeechchangeAttr => static::onwebkitspeechchangeAttr,
                static::onwebkittransitionendAttr => static::onwebkittransitionendAttr,
                static::openAttr => static::openAttr,
                static::optimumAttr => static::optimumAttr,
                static::patternAttr => static::patternAttr,
                static::pingAttr => static::pingAttr,
                static::placeholderAttr => static::placeholderAttr,
                static::playcountAttr => static::playcountAttr,
                static::pluginspageAttr => static::pluginspageAttr,
                static::pluginurlAttr => static::pluginurlAttr,
                static::posterAttr => static::posterAttr,
                static::precisionAttr => static::precisionAttr,
                static::preloadAttr => static::preloadAttr,
                static::primaryAttr => static::primaryAttr,
                static::profileAttr => static::profileAttr,
                static::progressAttr => static::progressAttr,
                static::promptAttr => static::promptAttr,
                static::readonlyAttr => static::readonlyAttr,
                static::relAttr => static::relAttr,
                static::requiredAttr => static::requiredAttr,
                static::resultsAttr => static::resultsAttr,
                static::revAttr => static::revAttr,
                static::roleAttr => static::roleAttr,
                static::rowsAttr => static::rowsAttr,
                static::rowspanAttr => static::rowspanAttr,
                static::rulesAttr => static::rulesAttr,
                static::sandboxAttr => static::sandboxAttr,
                static::schemeAttr => static::schemeAttr,
                static::scopeAttr => static::scopeAttr,
                static::scrollamountAttr => static::scrollamountAttr,
                static::scrolldelayAttr => static::scrolldelayAttr,
                static::scrollingAttr => static::scrollingAttr,
                static::selectedAttr => static::selectedAttr,
                static::shapeAttr => static::shapeAttr,
                static::sizeAttr => static::sizeAttr,
                static::sortableAttr => static::sortableAttr,
                static::sortdirectionAttr => static::sortdirectionAttr,
                static::spanAttr => static::spanAttr,
                static::spellcheckAttr => static::spellcheckAttr,
                static::srcAttr => static::srcAttr,
                static::srclangAttr => static::srclangAttr,
                static::standbyAttr => static::standbyAttr,
                static::startAttr => static::startAttr,
                static::stepAttr => static::stepAttr,
                static::styleAttr => static::styleAttr,
                static::summaryAttr => static::summaryAttr,
                static::tabindexAttr => static::tabindexAttr,
                static::tableborderAttr => static::tableborderAttr,
                static::targetAttr => static::targetAttr,
                static::textAttr => static::textAttr,
                static::titleAttr => static::titleAttr,
                static::topAttr => static::topAttr,
                static::topmarginAttr => static::topmarginAttr,
                static::truespeedAttr => static::truespeedAttr,
                static::typeAttr => static::typeAttr,
                static::usemapAttr => static::usemapAttr,
                static::valignAttr => static::valignAttr,
                static::valueAttr => static::valueAttr,
                static::valuetypeAttr => static::valuetypeAttr,
                static::versionAttr => static::versionAttr,
                static::viewsourceAttr => static::viewsourceAttr,
                static::vlinkAttr => static::vlinkAttr,
                static::vspaceAttr => static::vspaceAttr,
                static::webkitallowfullscreenAttr => static::webkitallowfullscreenAttr,
                static::webkitdirectoryAttr => static::webkitdirectoryAttr,
                static::webkitgrammarAttr => static::webkitgrammarAttr,
                static::webkitspeechAttr => static::webkitspeechAttr,
                static::widthAttr => static::widthAttr,
                static::wrapAttr => static::wrapAttr,
            );
        }
    }