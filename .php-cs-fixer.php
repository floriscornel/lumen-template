<?php declare(strict_types=1);

$finder = PhpCsFixer\Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/database/factories',
        __DIR__ . '/database/seeders',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ]);

$config = new PhpCsFixer\Config();

return $config
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2'                                  => true,
        'declare_strict_types'                   => true,
        'global_namespace_import'                => [
            'import_classes'   => true,
            'import_constants' => true,
            'import_functions' => true,
        ],
        'array_indentation'                      => true,
        'array_syntax'                           => ['syntax' => 'short'],
        'combine_consecutive_unsets'             => true,
        'class_attributes_separation'            => ['elements' => ['method' => 'one']],
        'multiline_whitespace_before_semicolons' => true,
        'single_quote'                           => true,
        'binary_operator_spaces'                 => [
            'operators' => [
                '=>' => 'align',
                // '='  => 'align',
            ],
        ],
        'braces' => [
            'allow_single_line_closure' => true,
        ],
        'cast_spaces'                     => true,
        'concat_space'                    => ['spacing' => 'one'],
        'declare_equal_normalize'         => true,
        'function_typehint_space'         => true,
        'single_line_comment_style'       => ['comment_types' => ['hash']],
        'include'                         => true,
        'lowercase_cast'                  => true,
        'new_with_braces'                 => true,
        'no_blank_lines_before_namespace' => false,
        'no_empty_comment'                => true,
        'no_empty_phpdoc'                 => true,
        'no_empty_statement'              => true,
        'no_extra_blank_lines'            => [
            'tokens' => [
                'curly_brace_block',
                'extra',
                'throw',
                'use',
            ],
        ],
        'php_unit_test_case_static_method_calls' => [
            'call_type' => 'this',
        ],
        'blank_line_after_namespace'                  => true,
        'no_leading_import_slash'                     => true,
        'no_leading_namespace_whitespace'             => true,
        'no_mixed_echo_print'                         => ['use' => 'echo'],
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_short_bool_cast'                          => true,
        'no_singleline_whitespace_before_semicolons'  => true,
        'no_spaces_around_offset'                     => true,
        'no_unneeded_control_parentheses'             => true,
        'no_unused_imports'                           => true,
        'no_whitespace_before_comma_in_array'         => true,
        'no_whitespace_in_blank_line'                 => true,
        'normalize_index_brace'                       => true,
        'object_operator_without_whitespace'          => true,
        'php_unit_fqcn_annotation'                    => true,
        'return_type_declaration'                     => true,
        'self_accessor'                               => true,
        'short_scalar_cast'                           => true,
        'single_blank_line_before_namespace'          => true,
        'single_class_element_per_statement'          => true,
        'space_after_semicolon'                       => true,
        'standardize_not_equals'                      => true,
        'ternary_operator_spaces'                     => true,
        'trailing_comma_in_multiline'                 => true,
        'trim_array_spaces'                           => true,
        'unary_operator_spaces'                       => true,
        'whitespace_after_comma_in_array'             => true,
        'space_after_semicolon'                       => true,
        'single_blank_line_at_eof'                    => true,
        'phpdoc_trim'                                 => true,
        'phpdoc_types'                                => true,
        'phpdoc_var_without_name'                     => true,
    ])
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setFinder($finder);
