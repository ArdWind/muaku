<?php

namespace App\Helpers;

class NumberConverter
{
  private static $units = ['', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan'];
  private static $tens = ['', 'sebelas', 'dua belas', 'tiga belas', 'empat belas', 'lima belas', 'enam belas', 'tujuh belas', 'delapan belas', 'sembilan belas'];
  private static $tens_prefix = ['', 'sepuluh', 'dua puluh', 'tiga puluh', 'empat puluh', 'lima puluh', 'enam puluh', 'tujuh puluh', 'delapan puluh', 'sembilan puluh'];
  private static $scales = ['', 'ribu', 'juta', 'milyar', 'triliun', 'kuadriliun'];

  /**
   * Mengkonversi angka numerik menjadi teks terbilang dalam Bahasa Indonesia.
   *
   * @param int|float|string $number Angka yang akan dikonversi.
   * @return string Teks terbilang.
   */
  public static function terbilang($number)
  {
    // Pastikan input adalah numerik dan diubah ke string
    $number = (string) $number;

    if (!is_numeric($number) || $number === '') {
      return ''; // Mengembalikan string kosong jika input tidak valid
    }

    // Pisahkan bagian integer dan desimal
    $parts = explode('.', $number);
    $integerPart = $parts[0];
    $decimalPart = isset($parts[1]) ? $parts[1] : '';

    // Handle angka nol
    if ($integerPart == '0' && $decimalPart == '') {
      return 'nol';
    }

    // Batasi hingga triliun agar tidak terlalu kompleks dan mencegah error yang tidak perlu
    // Angka 18 digit adalah batas sekitar 999 kuadriliun
    if (strlen($integerPart) > 18) {
      return 'Jumlah terlalu besar untuk dikonversi.';
    }

    $terbilangInteger = self::convertIntegerToWords($integerPart);
    $terbilangDecimal = '';

    // Proses bagian desimal jika ada
    if ($decimalPart !== '') {
      // Tambahkan 'koma' dan konversi setiap digit desimal
      $terbilangDecimal = ' koma';
      for ($i = 0; $i < strlen($decimalPart); $i++) {
        $digit = (int) $decimalPart[$i];
        $terbilangDecimal .= ' ' . self::$units[$digit];
      }
    }

    return trim($terbilangInteger . $terbilangDecimal);
  }

  /**
   * Mengkonversi bagian integer dari angka menjadi teks terbilang.
   *
   * @param string $numberString Bagian integer dalam bentuk string.
   * @return string Teks terbilang untuk bagian integer.
   */
  private static function convertIntegerToWords($numberString)
  {
    $words = '';
    $i = 0; // Indeks skala (ribu, juta, milyar, dll.)

    // Pad string dengan nol di depan agar panjangnya kelipatan 3
    // Kemudian pecah menjadi blok 3 digit dari kanan
    $paddedNumber = str_pad($numberString, ceil(strlen($numberString) / 3) * 3, '0', STR_PAD_LEFT);
    $blocks = array_reverse(str_split($paddedNumber, 3));

    foreach ($blocks as $block) {
      $block = (int) $block;
      if ($block == 0) {
        $i++;
        continue; // Lewati blok nol
      }

      $hundreds = floor($block / 100);
      $tensAndUnits = $block % 100;

      $blockWords = '';

      // Konversi ratusan
      if ($hundreds > 0) {
        $blockWords .= ($hundreds == 1 ? 'seratus' : self::$units[$hundreds] . ' ratus');
      }

      // Konversi puluhan dan satuan
      if ($tensAndUnits > 0) {
        if ($blockWords != '') {
          $blockWords .= ' '; // Tambahkan spasi jika sudah ada kata
        }
        if ($tensAndUnits < 10) {
          $blockWords .= self::$units[$tensAndUnits];
        } elseif ($tensAndUnits >= 10 && $tensAndUnits < 20) {
          $blockWords .= self::$tens[$tensAndUnits - 10];
        } else {
          $blockWords .= self::$tens_prefix[floor($tensAndUnits / 10)];
          if (($tensAndUnits % 10) > 0) {
            $blockWords .= ' ' . self::$units[$tensAndUnits % 10];
          }
        }
      }

      // Tambahkan skala (ribu, juta, milyar, dll.)
      if ($i > 0 && $blockWords != '') {
        // Penanganan khusus untuk "seribu" (bukan "satu ribu")
        if ($i == 1 && $blockWords == 'satu') {
          $blockWords = 'seribu';
        } elseif ($i == 1 && substr($blockWords, 0, 4) != 'satu' && $blockWords != 'seratus') { // Untuk "dua ribu", "tiga ratus ribu", dll.
          $blockWords .= ' ' . self::$scales[$i];
        } else {
          $blockWords .= ' ' . self::$scales[$i];
        }
      }

      $words = trim($blockWords . ' ' . $words); // Gabungkan dari kanan ke kiri
      $i++;
    }

    // Finalisasi penyesuaian jika ada
    $words = str_replace('satu ratus', 'seratus', $words); // Pastikan "satu ratus" menjadi "seratus"
    $words = str_replace('satu ribu', 'seribu', $words);   // Pastikan "satu ribu" menjadi "seribu"

    return $words;
  }
}
