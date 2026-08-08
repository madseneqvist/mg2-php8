<br />
<br />
<div align="center">
<div class="exif">
  <b><?php echo $mg2->lang['exif_info'];?></b>
  <br />
  <br />
<?php
	if ($mg2->showexif & 1)
		echo '<span class="item">
					<strong>'. $mg2->lang['make'] .'</strong> '.
					$exif_data['Make'] .'</span>
		';
	if ($mg2->showexif & 1<<1)
		echo '<span class="item">
					<strong>'. $mg2->lang['model'] .'</strong> '.
					$exif_data['Model'] .'</span>
		';
	if ($mg2->showexif & 1<<2)
		echo '<span class="item">
					<strong>'. $mg2->lang['shutter'] .'</strong> '.
					$exif_data['ExposureTime'] .'</span>
		';
	if ($mg2->showexif & 1<<3)
		echo '<span class="item">
					<strong>'. $mg2->lang['exposurecomp'] .'</strong> '.
					$exif_data['ExposureBias'] .'</span>
		';
	if ($mg2->showexif & 1<<4)
		echo '<span class="item">
					<strong>'. $mg2->lang['aperture'] .'</strong> '.
					$exif_data['FNumber'] .'</span>
		';
	if ($mg2->showexif & 1<<5)
		echo '<span class="item">
					<strong>'. $mg2->lang['focallength'] .'</strong> '.
					$exif_data['FocalLength'] .'</span>
		';
	if ($mg2->showexif & 1<<6)
		echo '<span class="item">
					<strong>'. $mg2->lang['iso'] .'</strong> '.
					$exif_data['ISOSpeedRating'] .'</span>
		';
	if ($mg2->showexif & 1<<7)
		echo '<span class="item">
					<strong>'. $mg2->lang['flash'] .'</strong> '.
					$exif_data['Flash'][1] .'</span>
		';
	if ($mg2->showexif & 1<<8)
		echo '<span class="item">
					<strong>'. $mg2->lang['original'] .'</strong> '.
					$exif_data['DTOpticalCapture'] .'</span>
		';
	if ($mg2->showexif & 1<<9)
		echo '<span class="item">
					<strong>'. $mg2->lang['software'] .'</strong> '.
					$exif_data['Software'] .'</span>
		';
	if ($mg2->showexif & 1<<10)
		echo '<span class="item">
					<strong>'. $mg2->lang['datetime'] .'</strong> '.
					$exif_data['DateTime'] .'</span>
		';
	if ($mg2->showexif & 1<<11)
		echo '<span class="item">
					<strong>'. $mg2->lang['colorspace'] .'</strong> '.
					$exif_data['ColorSpace'] .'</span>
		';
	if ($mg2->showexif & 1<<12)
		echo '<span class="item">
					<strong>'. $mg2->lang['photographer'] .'</strong> '.
					$exif_data['Photographer'] .'</span>
		';
?>
</div>
</div>
