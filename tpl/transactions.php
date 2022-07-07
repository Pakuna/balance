<table id="list">
    <thead>
        <tr>
            <td>Date</td>
            <td>Memo</td>
            <td>Amount</td>
        </tr>
    </thead>
    <tbody>
        <?php foreach($aTransactions as $oTransaction) include "tpl/entry.php"; ?>
    </tbody>
</table>