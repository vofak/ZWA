/**
 * Confirm dialog plugin
 *
 * @copyright  Copyright (c) 2012 Jan Červený
 * @license    BSD
 * @link       confirmdialog.redsoft.cz
 * @version    1.0
 */

//todo edit text
$(document).ready(function () {

    $('[data-confirm]').click(e => {
        e.preventDefault();
        let element = e.target;
        let confirmTimeout = $(element).data('confirm-timeout');
        let confirmInput = $(element).data('confirm-input');

        let modalEl = $(`
            <div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="modalLabel">Delete</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            Are you sure?
                        </div>
                        <div id="modal-confirm-input" class="modal-body">
                            
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="modal-cancel-button" data-dismiss="modal" data-confirm-timeout="${confirmTimeout}">Close</button>
                            <button type="button" class="btn btn-danger" id="modal-confirm-button">Delete it</button>
                        </div>
                    </div>
                </div>
            </div>
        `);
        modalEl.appendTo('body');
        modalEl.modal({backdrop:'static', keyboard: false});
        let confirmButton = $('#modal-confirm-button');
        let cancelButton = $('#modal-cancel-button');

        modalEl.on('hidden.bs.modal', function () {
            modalEl.remove();
        });

        if (confirmInput) {
            $('#modal-confirm-input').html(`
                <hr>
                <div>
                    <label>To confirm, please write '<strong>${confirmInput}</strong>'</label>
                    <input id="confirm_input" class="form-control text" type="text"/>
                </div>`);
            confirmButton.click(() => {
                let input = $("#confirm_input").val();
                if (input === confirmInput) {
                    document.location = element.href;
                    modalEl.modal('hide');
                }
            });
        }
        else {
            confirmButton.click(() => {
                document.location = element.href;
            });
        }

        if (confirmTimeout) {
            cancelButton.html('Close (' + confirmTimeout + ')');
            let countDownInterval = setInterval(() => {
                let t = cancelButton.data('confirm-timeout');
                let newTime = t - 1;
                if (newTime < 1) {
                    newTime = 1;
                }
                document.getElementById("modal-cancel-button").innerText = 'Close (' + newTime + ")";
                cancelButton.data('confirm-timeout', t - 1);
            }, 1000)

            setTimeout(() => {
                clearInterval(countDownInterval);
                modalEl.modal('hide');
            }, 10000);
        }


        modalEl.modal('show');
    })
});
