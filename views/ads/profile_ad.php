<tr>
    <td><? echo ($i + 1); ?></td>
    <td><? echo $ad['profession']; ?></td>
    <td><? echo $ad['updated']; ?></td>
    <td class="text-center">
        <input type="checkbox" name="<? echo "upd_".$i; ?>" <? if(intval($ad['upd']) == 1) echo "checked";?>>
    </td>
    <td class="text-center">
        <input type="checkbox" name="<? echo "del_".$i; ?>">
    </td>
    <td>
        <a class="btn btn-default btn-xs" href="<? echo $ad['url']; ?>" role="button">Show</a>
    </td>
</tr>