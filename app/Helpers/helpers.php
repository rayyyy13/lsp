<?php

/**
 * Mengkonversi teks yang mengandung hashtag (#tag) menjadi link yang bisa diklik.
 * Juga menangani escape HTML dan line break.
 * 
 * @param string $text - Teks mentah dari input user
 * @return string - Teks yang sudah diformat dengan link hashtag
 */
function linkHashtags($text)
{
    // Escape HTML terlebih dahulu untuk mencegah XSS
    $escaped = e($text);
    // Konversi newline (\n) menjadi tag <br>
    $withBreaks = nl2br($escaped);
    // Ubah setiap #kata menjadi link menuju halaman filter hashtag
    return preg_replace(
        '/#(\w+)/',
        '<a href="/hashtag/$1" class="text-sky-500 hover:underline">#<span>$1</span></a>',
        $withBreaks
    );
}