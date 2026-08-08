<?php
$distance = max(0, 175 - (int) $mg2->thumb_height);
?>
<td valign="top" align="center">
    <table cellpadding="0" cellspacing="0" class="thumb<?php if (!empty($mg2->new)) echo ' marknew'; ?>">
        <tr>
            <td>
                <a href="<?php $mg2->output('link'); ?>">
                    <img
                        src="<?php $mg2->output('thumbfile'); ?>"
                        border="0"
                        width="<?php $mg2->output('thumb_width'); ?>"
                        height="<?php $mg2->output('thumb_height'); ?>"
                        alt=""
                        class="thumb"
                    />
                    <br />
                    <img
                        src="skins/<?php echo htmlspecialchars((string) $mg2->activeskin, ENT_QUOTES, 'UTF-8'); ?>/images/1x1.gif"
                        width="1"
                        height="<?php echo $distance; ?>"
                        alt=""
                    />
                    <br />
                    <?php $mg2->output('title'); ?>
                </a>
            </td>
        </tr>
    </table>
</td>
