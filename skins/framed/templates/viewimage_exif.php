<br />
<br />
<table cellspacing="5" cellpadding="0" class="table_exif" width="300" align="center">
  <tr>
    <td colspan="2" align="center"><b><?php echo $mg2->lang['exif_info'];?></b></td>
  </tr>
<?php
	if ($mg2->showexif & 1)
		echo '<tr>
					<td>'. $mg2->lang['make'] .'</td>
					<td>'. $exif_data['Make'] .'</td>
				</tr>
		';
	if ($mg2->showexif & 1<<1)
		echo '<tr>
					<td>'. $mg2->lang['model'] .'</td>
					<td>'. $exif_data['Model'] .'</td>
				</tr>
		';
	if ($mg2->showexif & 1<<2)
		echo '<tr>
					<td>'. $mg2->lang['shutter'] .'</td>
					<td>'. $exif_data['ExposureTime'] .'</td>
				</tr>
		';
	if ($mg2->showexif & 1<<3)
		echo '<tr>
					<td>'. $mg2->lang['exposurecomp'] .'</td>
					<td>'. $exif_data['ExposureBias'] .'</td>
				</tr>
		';
	if ($mg2->showexif & 1<<4)
		echo '<tr>
					<td>'. $mg2->lang['aperture'] .'</td>
					<td>'. $exif_data['FNumber'] .'</td>
				</tr>
		';
	if ($mg2->showexif & 1<<5)
		echo '<tr>
					<td>'. $mg2->lang['focallength'] .'</td>
					<td>'. $exif_data['FocalLength'] .'</td>
				</tr>
		';
	if ($mg2->showexif & 1<<6)
		echo '<tr>
					<td>'. $mg2->lang['iso'] .'</td>
					<td>'. $exif_data['ISOSpeedRating'] .'</td>
				</tr>
		';
	if ($mg2->showexif & 1<<7)
		echo '<tr>
					<td>'. $mg2->lang['flash'] .'</td>
					<td>'. $exif_data['Flash'][1] .'</td>
				</tr>
		';
	if ($mg2->showexif & 1<<8)
		echo '<tr>
					<td>'. $mg2->lang['original'] .'</td>
					<td>'. $exif_data['DTOpticalCapture'] .'</td>
				</tr>
		';
	if ($mg2->showexif & 1<<9)
		echo '<tr>
					<td>'. $mg2->lang['software'] .'</td>
					<td>'. $exif_data['Software'] .'</td>
				</tr>
		';
	if ($mg2->showexif & 1<<10)
		echo '<tr>
					<td>'. $mg2->lang['datetime'] .'</td>
					<td>'. $exif_data['DateTime'] .'</td>
				</tr>
		';
	if ($mg2->showexif & 1<<11)
		echo '<tr>
					<td>'. $mg2->lang['colorspace'] .'</td>
					<td>'. $exif_data['ColorSpace'] .'</td>
				</tr>
		';
	if ($mg2->showexif & 1<<12)
		echo '<tr>
					<td>'. $mg2->lang['photographer'] .'</td>
					<td>'. $exif_data['Photographer'] .'</td>
				</tr>
		';
?>
</table>
