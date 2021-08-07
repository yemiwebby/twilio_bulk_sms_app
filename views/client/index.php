<?php

/* @var $this yii\web\View */

use yii\widgets\LinkPager;

?>
<h1>Clients</h1>
<table class="table" id="clientsTable">
    <thead>
    <tr>
        <th>&nbsp;</th>
        <th>#</th>
        <th>Name</th>
        <th>Phone number</th>
    </tr>
    </thead>
    <?php
    foreach ($clients as $i => $client): ?>
        <tr>
            <td><input type="checkbox"/></td>
            <td style="display: none"><?= $client->id ?></td>
            <td><?= $i + 1 ?></td>
            <td><?= $client->name ?></td>
            <td><?= $client->phoneNumber ?></td>
        </tr>
    <?php
    endforeach; ?>
</table>

<button
        class='btn btn-primary'
        style="display: block; margin: auto"
        onclick="sendSMS()"
>
    Send SMS
</button>
<div style="width: 50%; margin: auto">
    <?php
    echo LinkPager::widget(
        [
            'pagination' => $pagination,
        ]
    ); ?>
</div>

<script>
    const getSelectedClients = () => {
        const table = document.getElementById('clientsTable');
        const checkboxes = Array.from(table.getElementsByTagName('input'));
        const selectedClients = [];
        checkboxes
            .filter(checkbox => checkbox.checked)
            .forEach(checkbox => {
                    let row = checkbox.parentNode.parentNode;
                    selectedClients.push(row.cells[1].innerHTML)
                }
            )

        return selectedClients;
    }

    const sendSMS = () => {
        Swal.fire({
            title: 'Enter the content of the SMS',
            input: 'textarea',
            inputAttributes: {
                autocapitalize: 'off'
            },
            showCancelButton: true,
            confirmButtonText: 'Send',
            showLoaderOnConfirm: true,
            preConfirm: (smsContent) => {
                const data = {
                    clients: getSelectedClients(),
                    smsContent
                };
                return fetch('clients/notify', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(data)
                }).then(response => response.json()).then(data => {
                    Swal.fire({
                        title: data.message,
                    })
                })
                    .catch(error => {
                        Swal.showValidationMessage(
                            `Request failed: ${error}`
                        )
                    })
            },
            backdrop: true,
            allowOutsideClick: () => !Swal.isLoading()
        })
    }
</script>