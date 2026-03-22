<?php

class Core_Model_Upload_Image
{
  private $_exts = array("image/jpg", "image/jpeg", "image/png", "image/gif"); // Tipos MIME soportados
  private $_allowedExtensions = array("jpg", "jpeg", "png", "gif"); // Extensiones permitidas
  private $_width = 19200; // Ancho máximo
  private $_height = 19200; // Alto máximo
  private $_size = 2000097152; // Peso máximo (bytes)

  public function changeConfig($exts, $size, $width, $height)
  {
    if ($exts != null) {
      $this->_exts = $exts;
    }
    if ($width != null) {
      $this->_width = $width;
    }
    if ($height != null) {
      $this->_height = $height;
    }
    if ($size != null) {
      $this->_size = $size;
    }
  }

  public function upload($image, $resize = false)
  {
    // Si resize es true, usar dimensiones específicas de 170x150
    if ($resize) {
      $this->_width = 170;
      $this->_height = 150;
    } else {
      $this->_width = 8000;
      $this->_height = 8000;
    }

    if ($_FILES[$image]["error"] > 0) {
      print_r($_FILES[$image]["error"]);
      return false;
    }

    $fileType = $_FILES[$image]['type'];
    $extension = strtolower(pathinfo($_FILES[$image]['name'], PATHINFO_EXTENSION));

    // Validar MIME y extensión
    if (!in_array($fileType, $this->_exts) || !in_array($extension, $this->_allowedExtensions)) {
      return false;
    }

    if ($_FILES[$image]['size'] > $this->_size) {
      return false;
    }

    $filename = $this->clearName(pathinfo($_FILES[$image]['name'], PATHINFO_FILENAME));
    $name = $filename . '.' . $extension;
    $ruta = IMAGE_PATH . $name;

    // Evitar sobrescribir archivos
    $increment = 0;
    while (file_exists($ruta)) {
      $increment++;
      $name = $filename . $increment . '.' . $extension;
      $ruta = IMAGE_PATH . $name;
    }

    $origen = $_FILES[$image]['tmp_name'];
    $ancho_max = $this->_width;
    $alto_max = $this->_height;
    list($ancho_orig, $alto_orig) = getimagesize($origen);

    // Si resize es true, forzar redimensionamiento con crop centrado para mantener proporciones
    if ($resize || $ancho_orig > $ancho_max || $alto_orig > $alto_max) {
      if ($resize) {
        // Calcular dimensiones para crop centrado (evita distorsión)
        $ratio_orig = $ancho_orig / $alto_orig;
        $ratio_dest = $ancho_max / $alto_max;

        if ($ratio_orig > $ratio_dest) {
          // La imagen es más ancha proporcionalmente
          $ancho_temp = $alto_orig * $ratio_dest;
          $alto_temp = $alto_orig;
          $src_x = ($ancho_orig - $ancho_temp) / 2;
          $src_y = 0;
        } else {
          // La imagen es más alta proporcionalmente
          $ancho_temp = $ancho_orig;
          $alto_temp = $ancho_orig / $ratio_dest;
          $src_x = 0;
          $src_y = ($alto_orig - $alto_temp) / 2;
        }

        $canvas = imagecreatetruecolor($ancho_max, $alto_max);

        // Mejorar la calidad del redimensionamiento
        imagefill($canvas, 0, 0, imagecolorallocate($canvas, 255, 255, 255));

        switch ($fileType) {
          case "image/jpg":
          case "image/jpeg":
            $imageRes = $this->createImageFromJpegWithOrientation($origen);
            $ancho_orig = imagesx($imageRes);
            $alto_orig = imagesy($imageRes);

            $ratio_orig = $ancho_orig / $alto_orig;
            $ratio_dest = $ancho_max / $alto_max;

            if ($ratio_orig > $ratio_dest) {
              $ancho_temp = $alto_orig * $ratio_dest;
              $alto_temp = $alto_orig;
              $src_x = ($ancho_orig - $ancho_temp) / 2;
              $src_y = 0;
            } else {
              $ancho_temp = $ancho_orig;
              $alto_temp = $ancho_orig / $ratio_dest;
              $src_x = 0;
              $src_y = ($alto_orig - $alto_temp) / 2;
            }

            imagecopyresampled($canvas, $imageRes, 0, 0, $src_x, $src_y, $ancho_max, $alto_max, $ancho_temp, $alto_temp);
            imagejpeg($canvas, $ruta, 95);
            break;
          case "image/gif":
            $imageRes = imagecreatefromgif($origen);
            // Preservar transparencia en GIF
            $transparent = imagecolortransparent($imageRes);
            if ($transparent >= 0) {
              $transparentColor = imagecolorsforindex($imageRes, $transparent);
              $transparentNew = imagecolorallocate($canvas, $transparentColor['red'], $transparentColor['green'], $transparentColor['blue']);
              imagefill($canvas, 0, 0, $transparentNew);
              imagecolortransparent($canvas, $transparentNew);
            }
            imagecopyresampled($canvas, $imageRes, 0, 0, $src_x, $src_y, $ancho_max, $alto_max, $ancho_temp, $alto_temp);
            imagegif($canvas, $ruta);
            break;
          case "image/png":
            $imageRes = imagecreatefrompng($origen);
            // Preservar transparencia en PNG
            imagealphablending($canvas, false);
            imagesavealpha($canvas, true);
            $transparent = imagecolorallocatealpha($canvas, 255, 255, 255, 127);
            imagefill($canvas, 0, 0, $transparent);
            imagecopyresampled($canvas, $imageRes, 0, 0, $src_x, $src_y, $ancho_max, $alto_max, $ancho_temp, $alto_temp);
            imagepng($canvas, $ruta, 8);
            break;
        }
        imagedestroy($imageRes);
        imagedestroy($canvas);
      } else {
        // Redimensionamiento normal (sin crop) para imágenes grandes
        $ratio_orig = $ancho_orig / $alto_orig;
        if ($ancho_max / $alto_max > $ratio_orig) {
          $ancho_max = $alto_max * $ratio_orig;
        } else {
          $alto_max = $ancho_max / $ratio_orig;
        }

        $canvas = imagecreatetruecolor($ancho_max, $alto_max);
        switch ($fileType) {
          case "image/jpg":
          case "image/jpeg":
            $imageRes = $this->createImageFromJpegWithOrientation($origen);
            $ancho_orig = imagesx($imageRes);
            $alto_orig = imagesy($imageRes);

            $ratio_orig = $ancho_orig / $alto_orig;
            if ($ancho_max / $alto_max > $ratio_orig) {
              $ancho_max = $alto_max * $ratio_orig;
            } else {
              $alto_max = $ancho_max / $ratio_orig;
            }

            imagedestroy($canvas);
            $canvas = imagecreatetruecolor($ancho_max, $alto_max);

            imagecopyresampled($canvas, $imageRes, 0, 0, 0, 0, $ancho_max, $alto_max, $ancho_orig, $alto_orig);
            imagejpeg($canvas, $ruta, 100);
            break;
          case "image/gif":
            $imageRes = imagecreatefromgif($origen);
            imagecopyresampled($canvas, $imageRes, 0, 0, 0, 0, $ancho_max, $alto_max, $ancho_orig, $alto_orig);
            imagegif($canvas, $ruta);
            break;
          case "image/png":
            $imageRes = imagecreatefrompng($origen);
            imagecopyresampled($canvas, $imageRes, 0, 0, 0, 0, $ancho_max, $alto_max, $ancho_orig, $alto_orig);
            imagepng($canvas, $ruta, 0);
            break;
        }
        imagedestroy($imageRes);
        imagedestroy($canvas);
      }
    } else {
      move_uploaded_file($origen, $ruta);
    }

    return $name;
  }

  private function createImageFromJpegWithOrientation($path)
  {
    $imageRes = imagecreatefromjpeg($path);
    if (!$imageRes) {
      return $imageRes;
    }

    if (!function_exists('exif_read_data')) {
      return $imageRes;
    }

    $exif = @exif_read_data($path);
    $orientation = isset($exif['Orientation']) ? (int) $exif['Orientation'] : 1;

    switch ($orientation) {
      case 3:
        $rotated = imagerotate($imageRes, 180, 0);
        if ($rotated) {
          imagedestroy($imageRes);
          $imageRes = $rotated;
        }
        break;
      case 6:
        $rotated = imagerotate($imageRes, -90, 0);
        if ($rotated) {
          imagedestroy($imageRes);
          $imageRes = $rotated;
        }
        break;
      case 8:
        $rotated = imagerotate($imageRes, 90, 0);
        if ($rotated) {
          imagedestroy($imageRes);
          $imageRes = $rotated;
        }
        break;
    }

    return $imageRes;
  }

  public function delete($image)
  {
    if (file_exists(IMAGE_PATH . $image)) {
      unlink(IMAGE_PATH . $image);
      return true;
    }
    return false;
  }

  private function clearName($str)
  {
    $tildes = array('á', 'é', 'í', 'ó', 'ú', 'ñ', 'Á', 'É', 'Í', 'Ó', 'Ú', 'Ñ');
    $vocales = array('a', 'e', 'i', 'o', 'u', 'n', 'A', 'E', 'I', 'O', 'U', 'N');
    $str = str_replace($tildes, $vocales, $str);
    $simbolos = array("=", "¿", "?", "¡", "!", "'", "%", "$", "€", "(", ")", "[", "]", "{", "}", "*", "+", "·", ".", "<", ">");
    $str = str_replace($simbolos, "", $str);
    $str = str_replace(" ", "_", $str);
    return strtolower($str);
  }

  public function uploadmultiple($image)
  {
    $permitidos = $this->_exts;
    $extPermitidas = $this->_allowedExtensions;
    $limite_kb = 2000;
    $images = array();

    foreach ($_FILES[$image]["tmp_name"] as $key => $tmp_name) {
      $fileType = $_FILES[$image]['type'][$key];
      $extension = strtolower(pathinfo($_FILES[$image]['name'][$key], PATHINFO_EXTENSION));

      if (
        in_array($fileType, $permitidos) && in_array($extension, $extPermitidas) &&
        $_FILES[$image]['size'][$key] <= $limite_kb * 1024
      ) {

        $filename = $this->clearName(pathinfo($_FILES[$image]['name'][$key], PATHINFO_FILENAME));
        $name = $filename . '.' . $extension;
        $ruta = IMAGE_PATH . $name;

        $increment = 0;
        while (file_exists($ruta)) {
          $increment++;
          $name = $filename . $increment . '.' . $extension;
          $ruta = IMAGE_PATH . $name;
        }

        if (move_uploaded_file($_FILES[$image]['tmp_name'][$key], $ruta)) {
          $images[$key] = "images/" . $name;
        }
      }
    }

    return (count($images) > 0) ? $images : false;
  }

  public function uploadThumbs($image)
  {
    $this->_width = 500;
    $this->_height = 500;

    if ($_FILES[$image]["error"] > 0) {
      print_r($_FILES[$image]["error"]);
      return false;
    }

    $fileType = $_FILES[$image]['type'];
    $extension = strtolower(pathinfo($_FILES[$image]['name'], PATHINFO_EXTENSION));

    if (!in_array($fileType, $this->_exts) || !in_array($extension, $this->_allowedExtensions)) {
      return false;
    }

    if ($_FILES[$image]['size'] > $this->_size) {
      return false;
    }

    $filename = $this->clearName(pathinfo($_FILES[$image]['name'], PATHINFO_FILENAME));
    $name = $filename . '.' . $extension;
    $ruta = IMAGE_PATH . 'thumbs/' . $name;

    $increment = 0;
    while (file_exists($ruta)) {
      $increment++;
      $name = $filename . $increment . '.' . $extension;
      $ruta = IMAGE_PATH . 'thumbs/' . $name;
    }

    $origen = $_FILES[$image]['tmp_name'];
    $ancho_max = $this->_width;
    $alto_max = $this->_height;
    list($ancho_orig, $alto_orig) = getimagesize($origen);

    if ($ancho_orig > $ancho_max || $alto_orig > $alto_max) {
      $ratio_orig = $ancho_orig / $alto_orig;
      if ($ancho_max / $alto_max > $ratio_orig) {
        $ancho_max = $alto_max * $ratio_orig;
      } else {
        $alto_max = $ancho_max / $ratio_orig;
      }

      $canvas = imagecreatetruecolor($ancho_max, $alto_max);
      switch ($fileType) {
        case "image/jpg":
        case "image/jpeg":
          $imageRes = $this->createImageFromJpegWithOrientation($origen);
          $ancho_orig = imagesx($imageRes);
          $alto_orig = imagesy($imageRes);

          $ratio_orig = $ancho_orig / $alto_orig;
          if ($ancho_max / $alto_max > $ratio_orig) {
            $ancho_max = $alto_max * $ratio_orig;
          } else {
            $alto_max = $ancho_max / $ratio_orig;
          }

          imagedestroy($canvas);
          $canvas = imagecreatetruecolor($ancho_max, $alto_max);

          imagecopyresampled($canvas, $imageRes, 0, 0, 0, 0, $ancho_max, $alto_max, $ancho_orig, $alto_orig);
          imagejpeg($canvas, $ruta, 100);
          break;
        case "image/gif":
          $imageRes = imagecreatefromgif($origen);
          imagecopyresampled($canvas, $imageRes, 0, 0, 0, 0, $ancho_max, $alto_max, $ancho_orig, $alto_orig);
          imagegif($canvas, $ruta);
          break;
        case "image/png":
          $imageRes = imagecreatefrompng($origen);
          imagecopyresampled($canvas, $imageRes, 0, 0, 0, 0, $ancho_max, $alto_max, $ancho_orig, $alto_orig);
          imagepng($canvas, $ruta, 0);
          break;
      }
      imagedestroy($imageRes);
      imagedestroy($canvas);
    } else {
      move_uploaded_file($origen, $ruta);
    }

    return $name;
  }
}
