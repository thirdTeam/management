<tr>
    <td><? echo ($i + 1); ?></td>
    <td><? echo $sub['profession']; ?></td>
    <td><? echo $sub['city']; ?></td>
    <td><? echo $sub['salary']; ?></td>
    <td>
        <input type="checkbox" name="<? echo "unsub_".$i; ?>">
    </td>
</tr>