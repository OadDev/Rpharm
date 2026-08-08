<?php

namespace App\Support;

class EnvironmentWriter
{
    /**
     * Set one or more key=value pairs in the .env file, preserving everything else.
     *
     * @param  array<string, string>  $values
     */
    public static function set(array $values): void
    {
        $path = base_path('.env');
        $content = file_exists($path) ? file_get_contents($path) : '';

        foreach ($values as $key => $value) {
            $line = $key.'='.static::quote($value);

            if (preg_match('/^'.preg_quote($key, '/').'=.*$/m', $content)) {
                $content = preg_replace('/^'.preg_quote($key, '/').'=.*$/m', $line, $content);
            } else {
                $content = rtrim($content)."\n".$line."\n";
            }
        }

        file_put_contents($path, $content);
    }

    private static function quote(string $value): string
    {
        if ($value === '' || preg_match('/\s|#|"/', $value)) {
            return '"'.str_replace('"', '\"', $value).'"';
        }

        return $value;
    }
}
