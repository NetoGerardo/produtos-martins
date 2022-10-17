export default {
    methods: {

        handleRemove(title, id, callBackSuccess) {
            this.$swal
                .fire({
                    title: title,
                    text: "Voce nao poderá reverter essa operação!",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim, quero deletar!"
                })
                .then(result => {
                    if (result.value) {
                        callBackSuccess(id);
                    }
                });
        },

        confirmWarning(title, callBackSuccess) {
            this.$swal
                .fire({
                    title: title,
                    text: "Voce nao poderá reverter essa operação!",
                    icon: "warning",
                    padding: '1.5em',
                    showCancelButton: true,
                    confirmButtonColor: "#4caf50",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim!"
                })
                .then(result => {
                    if (result.value) {
                        callBackSuccess();
                        this.$swal.fire({
                            title: "Ok!",
                            text: "O processo foi executado com sucesso.",
                            padding: '1.5em',
                            icon: "success",
                            confirmButtonText: "OK!"
                        }
                        );
                    }
                });
        },

        confirmarEnvio(title, mensagem, callBackSuccess) {
            this.$swal
                .fire({
                    title: title,
                    text: mensagem,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#4caf50",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim!",
                    padding: '1.5em',
                    className: 'swal-modal',
                    customClass: {
                        container: 'swal-modal',
                        popup: 'swal-modal',
                        header: 'swal-modal',
                        title: 'swal-modal',
                        closeButton: 'swal-modal',
                        icon: 'swal-modal',
                        image: 'swal-modal',
                        content: 'swal-modal',
                        input: 'swal-modal',
                        actions: 'swal-modal',
                        confirmButton: 'swal-modal',
                        cancelButton: 'swal-modal',
                        footer: 'swal-modal'
                    }
                })
                .then(result => {
                    if (result.value) {
                        callBackSuccess();
                        this.$swal.fire(
                            "Ok!",
                            "O processo foi executado com sucesso.",
                            "success"
                        );
                    }
                });
        },

        confirmarRecuperacaoMensagens(title, html, callBackSuccess) {
            this.$swal
                .fire({
                    title: title,
                    html: html,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#4caf50",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim!"
                })
                .then(result => {
                    if (result.value) {
                        callBackSuccess();
                    }
                });
        },

        showErrorMessage(msg) {
            this.$swal.fire({
                toast: true,
                icon: "error",
                title: msg,
                position: "top-end",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                onOpen: toast => {
                    toast.addEventListener("mouseenter", this.$swal.stopTimer);
                    toast.addEventListener("mouseleave", this.$swal.resumeTimer);
                }
            });
        },

        showSuccessMessage(msg) {
            this.$swal.fire({
                toast: true,
                icon: "success",
                title: msg,
                position: "top-end",
                showConfirmButton: false,
                padding: '1.5em',
                timer: 3000,
                timerProgressBar: true,
                onOpen: toast => {
                    toast.addEventListener("mouseenter", this.$swal.stopTimer);
                    toast.addEventListener("mouseleave", this.$swal.resumeTimer);
                }
            });
        },

        showErrorMessageWithButton(tittle, message) {
            this.$swal.fire({
                icon: 'error',
                title: tittle,
                padding: '1.5em',
                text: message,
            })
        },

        showErrorWithButton(title, mensagem, html) {
            // Use sweetalert2
            this.$swal
                .fire({
                    title: title,
                    text: mensagem,
                    icon: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#4caf50",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim!",
                    html: html
                })
                .then(result => {
                    result;
                });
        },

        edit(nome, status1, status2, email, callback) {
            this.$swal.fire({
                title: 'Editar Usuário',
                showCancelButton: true,
                html:
                    '<label for="nome">Nome</label>' +
                    '<input id="swal-input1" class="form-control" value="' + nome + '">' +
                    '<br/>' +
                    '<label for="status">Status</label>' +
                    '<select class="form-control" id="status">' +
                    '<option value="' + status1 + '">' + status1 + '</option>' +
                    '<option value="' + status2 + '">' + status2 + '</option>' +
                    '</select>' +
                    '<br/>' +
                    '<label for="email">Email</label>' +
                    '<input id="swal-input3" class="form-control" value="' + email + '">' +
                    '<br/>' +
                    '<label for="senha">Redefinir Senha</label>' +
                    '<input id="swal-input2" class="form-control" />',
                focusConfirm: false,
                preConfirm: () => {
                    return [
                        document.getElementById('swal-input1').value,
                        document.getElementById('swal-input2').value,
                        document.getElementById('status').value,
                        document.getElementById('swal-input3').value,
                    ]
                }
            }).then((response) => {
                if (response) {
                    callback(response);
                }
            })

        },

        editUser(nome, email, callback) {
            this.$swal.fire({
                title: 'Editar Usuário',
                showCancelButton: true,
                html:
                    '<label for="nome">Nome</label>' +
                    '<input id="swal-input1" class="form-control" value="' + nome + '">' +
                    '<br/>' +
                    '<label for="email">Email</label>' +
                    '<input id="swal-input2" class="form-control" value="' + email + '">' +
                    '<br/>' +
                    '<label for="senha">Redefinir Senha</label>' +
                    '<input id="swal-input3" class="form-control" />',
                focusConfirm: false,
                preConfirm: () => {
                    return [
                        document.getElementById('swal-input1').value,
                        document.getElementById('swal-input2').value,
                        document.getElementById('swal-input3').value,
                    ]
                }
            }).then((response) => {
                if (response) {
                    callback(response);
                }
            })

        },

        editLista(nome, callback) {
            this.$swal.fire({
                title: 'Editar Lista',
                showCancelButton: true,
                html:
                    '<label for="nome">Nome</label>' +
                    '<input id="swal-input1" class="form-control" value="' + nome + '">' +
                    '<br/>',
                focusConfirm: false,
                preConfirm: () => {
                    return [
                        document.getElementById('swal-input1').value,
                    ]
                }
            }).then((response) => {
                if (response) {
                    callback(response);
                }
            })

        },

        confirmDeleteList(title, mensagem, callBackSuccess) {
            this.$swal
                .fire({
                    title: title,
                    text: mensagem,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#4caf50",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim!"
                })
                .then(result => {
                    if (result.value) {
                        callBackSuccess();
                    }
                });
        },

        confirmarCadastroLead(title, html, callBackSuccess) {
            this.$swal
                .fire({
                    title: title,
                    html: html,
                    icon: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#4caf50",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim!"
                })
                .then(result => {
                    if (result.value) {
                        callBackSuccess();
                    }
                });
        },
    }
};


