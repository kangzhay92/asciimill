<?php

class AsciiMill
{
    var $image;
    var $width, $height;
    var $desired_width, $desired_height;

    public function StartProcess($image)
    {
        // mengupload file image dari input
        move_uploaded_file($image['tmp_name'], 'jangan_hapus_folder_ini/'.$image['name']);
        chmod('jangan_hapus_folder_ini/'.$image['name'], 0644);

        // masukkan image ke dalam class variable
        $this->image = 'jangan_hapus_folder_ini/'.$image['name'];

        // mendapatkan width, height, dan type image
        list($width, $height, $type) = getimagesize($this->image);

        // 1=gif, 2=jpg, 3=png, 6=bmp.
        // Ini adalah format image yang dipakai dalam class ini.
        if ($type == '1')
        {
            $render_image = imagecreatefromgif($this->image);
        }
        elseif ($type == '2')
        {
            $render_image = imagecreatefromjpeg($this->image);
        }
        elseif ($type == '3')
        {
            $render_image = imagecreatefrompng($this->image);
        }
        elseif ($type == '6')
        {
            $render_image = imagecreatefromwbmp($this->image);
        }
        else
        {
            unlink($this->image);
            die("<div style='color: #fff;'>Invalid Image Format. Only JPG, GIF, PNG, and BMP are allowed.</div>");
        }

        // atur width dan height
        $this->width  = imagesx($render_image);
        $this->height = imagesy($render_image);
		
        ?>
        <div style="float: center; text-align: center">
			<?php 
			$this->CreateEnvironment($render_image); 
			echo $this->ShowFooter();
			?>
		</div>
        <?php
    }

    private function CreateEnvironment($image)
    {
        // ubah ukuran image dan membuat image baru dengan
        // width dan height yang sudah ditentukan
        $this->desired_width = '83';
        $report = $this->width / $this->desired_width;
        $this->desired_height = floor($this->height / $report);
        $post_image = imagecreatetruecolor($this->desired_width, $this->desired_height);
        imagecopyresized($post_image, $image, 0, 0, 0, 0, $this->desired_width, $this->desired_height, $this->width, $this->height);

        // selesai membuat environment, langsung ke tahap proses
        $this->CreateAsciiArt($post_image);
    }

    private function CreateAsciiArt($image)
    {
        for ($y = 0; $y < $this->desired_height; $y++)
        {
            for ($x = 0; $x < $this->desired_width; $x++)
            {
                // mencari kode warna dari setiap pixel
                $get_pixel_color = imagecolorat($image, $x, $y);
                $red   = ($get_pixel_color >> 16) & 0xff;
                $green = ($get_pixel_color >>  8) & 0xff;
                $blue  = $get_pixel_color & 0xff;

                // ubah ke dalam bentuk hex
                $final_color = $this->GetHexFromColor($red, $green, $blue);
                echo '<a style="color: '.$final_color.';">##</a>';
            }
            echo '<br>';
        }
        unlink($this->image);
    }

    private function GetHexFromColor($red, $green, $blue)
    {
        $mark  = '#';    // special character untuk hex, contoh: #ffffff
        $red   = dechex($red);
        $green = dechex($green);
        $blue  = dechex($blue);
        return $mark.$red.$green.$blue;
    }

    public function ShowFooter()
    {
        return
            "
            <footer class='footer text-center' style='color: #fff;'>
                Copyright &copy; 2016 Muhammad Idzhar
            </footer>
            ";
    }
}