<?php

$fixers = array(
    '-psr0',                              // Remove PSR0 filter, our Sumo files don't match namespace with path
    'double_arrow_multiline_whitespaces', // [symfony] Operator => should not be arounded by multi-line whitespaces.
    'duplicate_semicolon',                // [symfony] Remove duplicated semicolons.
    'empty_return',                       // [symfony] A return statement returning nothing should be simply "return".
    'extra_empty_lines',                  // [symfony] Removes extra empty lines.
    'include',                            // [symfony] Include and file path should be divided with a single space.
    'namespace_no_leading_whitespace',    // [symfony] The namespace declaration shouldn't contain leading whitespace.
    'new_with_braces',                    // [symfony] All instances created with `new` must be followed by braces.
    'object_operator',                    // [symfony] There should not be space before or after object `->`.
    'operators_spaces',                   // [symfony] Operators should be arounded by at least one space.
    'remove_leading_slash_use',           // [symfony] Remove leading slashes in use clauses.
    'remove_lines_between_uses',          // [symfony] Removes line breaks between use statements.
    'return',                             // [symfony] An empty line feed should precede a return statement.
    'single_array_no_trailing_comma',     // [symfony] PHP single-line arrays should not have trailing comma.
    'spaces_before_semicolon',            // [symfony] Single-line whitespace before closing semicolon are prohibited.
    'spaces_cast',                        // [symfony] A single space should be between cast and variable.
    'ternary_spaces',                     // [symfony] Standardize spaces around ternary operator.
    'unused_use',                         // [symfony] Unused use statements must be removed.
    'whitespacy_lines',                   // [symfony] Remove trailing whitespace at the end of blank lines.
    'align_double_arrow',                 // [contrib] Align double arrow symbols in consecutive lines.
    'align_equals',                       // [contrib] Align equals symbols in consecutive lines.
    'concat_with_spaces',                 // [contrib] Concatenation should be used with at least one whitespace around.
    'multiline_spaces_before_semicolon',  // [contrib] Multi-line whitespace before closing semicolon are prohibited.
    'ordered_use',                        // [contrib] Ordering use statements.
    'short_array_syntax',                 // [contrib] PHP array's should use the PHP 5.4 short-syntax.
    'indentation',                        // [PSR-2] Code MUST use an indent of 4 spaces, and MUST NOT use tabs for indenting.
);

$finder = Symfony\CS\Finder\DefaultFinder::create();
$finder->in(__DIR__ . '/src');
$finder->in(__DIR__ . '/tests');

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers($fixers)
    ->finder($finder);
