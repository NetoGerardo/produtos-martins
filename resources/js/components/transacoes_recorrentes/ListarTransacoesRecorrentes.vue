<template>
    <div>
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />
        <div class="card-body p-0">
            <table class="table">
                <thead>
                    <tr>
                        <th style="width: 25%">Nome</th>
                        <th style="width: 25%">Data da criação</th>
                        <th style="width: 25%">Tipo</th>
                        <th style="width: 25%">Valor</th>
                        <th style="width: 12%">Detalhes</th>
                        <th style="width: 13%">Deletar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="transacao_recorrente in aux_transacoes_recorrentes" :key="transacao_recorrente">
                        <td data-label="Nome">{{ transacao_recorrente.nome }}</td>
                        <td data-label="Data">
                            {{ formatDate(transacao_recorrente.created_at) }}
                        </td>
                        <td data-label="Produto">R${{ transacao_recorrente.valor }}</td>
                        <td data-label="Produto">R${{ transacao_recorrente.valor }}</td>
                        <td>
                            <button data-toggle="modal" data-target="#detalhes-modal"
                                @click="show(transacao_recorrente)" type="button" class="btn btn-primary btn-sm">
                                Detalhes
                            </button>
                        </td>
                        <td>
                            <button @click="deletarTransacao(transacao_recorrente)" type="button"
                                class="btn btn-danger btn-sm">
                                Deletar
                                <i class="fa fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="modal fade" id="detalhes-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <form @submit.prevent>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4>Detalhes da Transação</h4>
                            <br />
                            <div class="form-group">
                                <label for="email">Nome</label>
                                <input readonly="true" style="background-color: black" class="form-control" id="nome"
                                    type="text" v-model="transacao_recorrente_selecionada.nome" autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <label for="email">Valor</label>
                                <input readonly="true" style="background-color: black" class="form-control" id="nome"
                                    type="text" v-model="transacao_recorrente_selecionada.valor" autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <label for="email">Descrição</label>
                                <input readonly="true" style="background-color: black" class="form-control" id="nome"
                                    type="text" v-model="transacao_recorrente_selecionada.descricao"
                                    autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <label for="email">Data de criação</label>
                                <input readonly="true" style="background-color: black" class="form-control" id="nome"
                                    type="text" :value="formatDate(transacao_recorrente_selecionada.created_at)" />
                            </div>

                            <div class="form-group">
                                <label for="email">Próxima transação</label>
                                <input readonly="true" style="background-color: black" class="form-control" id="nome"
                                    type="text" :value="formatDate(transacao_recorrente_selecionada.created_at)" />
                            </div>

                            <button class="btn btn-primary btn-flat" data-dismiss="modal">
                                Voltar <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
  
<script>
import sweetAlert from "../controller/sweetAlert";
import Swal from "sweetalert2/dist/sweetalert2.js";
import Loading from "vue-loading-overlay";
import moment from "moment";
import "vue-loading-overlay/dist/vue-loading.css";

export default {

    props: ['transacoes_recorrentes'],

    mixins: [sweetAlert, Swal],

    components: [Loading],

    data() {
        return {
            nome: "",
            isLoading: false,
            transacao_recorrente_selecionada: "",
            aux_transacoes_recorrentes: ""
        };
    },

    mounted() {
        this.aux_transacoes_recorrentes = this.transacoes_recorrentes;
    },

    methods: {

        show(transacao_recorrente) {
            this.transacao_recorrente_selecionada = transacao_recorrente;
        },

        deletarTransacao(transacao) {
            this.$swal
                .fire({
                    title: "<h2 style='color:#616060'>Deseja deletar esta transação? <b>" + transacao.nome + "</b></h2>",
                    text: "Voce nao poderá reverter essa operação!",
                    icon: "warning",
                    padding: '1.5em',
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Sim, quero deletar!"
                })
                .then(result => {
                    if (result.value) {
                        this.deletar(transacao);
                    }
                });
        },


        deletar(transacao_recorrente) {

            let data = {
                transacao_recorrente_id: transacao_recorrente.id
            }

            axios
                .post(`/user/transacoes_recorrentes/delete`, data)
                .then((response) => {

                    this.showSuccessMessage("Transação deletada!");

                    let indice = this.findTransaction(transacao_recorrente.id);

                    if (indice >= 0) {
                        const element = this.aux_transacoes_recorrentes.splice(indice, 1)[0];
                        console.log(element);
                    }

                })
                .catch((error) => {
                    this.showErrorMessageWithButton("Ops..", error.response.data);
                    console.log(error.response.data);
                });
        },

        findTransaction(id) {
            let user = this.aux_transacoes_recorrentes.findIndex(element => element['id'] == id);

            return user;
        },


        validateFields() {
            if (!this.nome) {
                this.showErrorMessageWithButton("Ops...", "O campo nome é obrigatório!");
            } else {
                this.create();
            }
        },

        create() {
            this.isLoading = true;

            let data = {
                nome: this.nome,
            };

            console.log("CRIANDO");
            console.log(data);

            axios
                .post(`/user/categorias/store`, data)
                .then((response) => {
                    console.log("Usuário criado!");
                    console.log(response);

                    this.showSuccessMessage("Usuário criado!");

                    window.location.reload();
                })
                .catch((error) => {
                    this.showErrorMessageWithButton("Ops..", error.response.data);
                    console.log(error.response.data);
                });
        },

        formatDate(date) {
            return moment(date).format("DD/MM/YYYY HH:mm:ss");
        },
    },
};
</script>


<style scoped>
label {
    font-weight: normal;
    color: gray;
}

.stati {
    background: #fff;
    width: 12em;
    height: 4em;
    padding: 1em;
    margin: 1em 0;
    /* Safari */
    box-shadow: 0px 0.2em 0.3em rgb(0, 0, 0, 0.8);
}

.stati.bg-orange {
    background: rgb(243, 156, 18);
    color: white;
}

.stati.bg-nephritis {
    background: rgb(39, 174, 96);
    color: white;
}

.stati.bg-peter_river {
    background: rgb(52, 152, 219);
    color: white;
}

.stati.bg-green_sea {
    background: rgb(22, 160, 133);
    color: white;
}

.stati div {
    width: calc(100% - 3.5em);
    display: block;
    float: right;
    text-align: right;
}

.stati fa {
    font-size: 3.5em;
}

.stati div {
    width: calc(100% - 3.5em);
    display: block;
    float: right;
    text-align: right;
}

.stati div b {
    font-size: 2.2em;
    width: 100%;
    padding-top: 0px;
    margin-top: -0.2em;
    margin-bottom: -0.2em;
    display: block;
}

.stati div span {
    font-size: 1em;
    width: 100%;
    color: rgb(0, 0, 0, 0.8);
    display: block;
}

.stati.left div {
    float: left;
    text-align: left;
}

.stati.bg-turquoise {
    background: rgb(26, 188, 156);
    color: white;
}

table {
    border: 1px solid rgb(58, 50, 50);
    border-collapse: collapse;
    margin: 0;
    padding: 0;
    width: 100%;
    table-layout: fixed;
}

table tr:nth-child(even) {
    background: rgb(0, 0, 0);
}

table tr:nth-child(odd) {
    background: rgb(0, 0, 0);
}

table.pdi tr:nth-child(even) {
    background: rgb(0, 0, 0);
}

table.pdi tr:nth-child(odd) {
    background: #80f0af;
}

table caption {
    font-size: 1.2em;
    margin: 0.1em 0 0.5em;
}

table tr {
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    padding: 0.1em;
}

table th,
table td {
    padding: 0.2em;
    text-align: center;
    font-size: 0.9em;
}

table th {
    font-size: 0.7em;
    letter-spacing: 0.1em;
    text-transform: uppercase;
}

@media screen and (max-width: 600px) {
    table {
        border: 0;
    }

    table caption {
        font-size: 1em;
    }

    table thead {
        border: none;
        clip: rect(0 0 0 0);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
    }

    table tr {
        border-bottom: 3px solid #ddd;
        display: block;
        margin-bottom: 0.625em;
    }

    table td {
        padding: 0.4em;
        border-bottom: 1px solid #ddd;
        display: block;
        font-size: 0.9em;
        text-align: right;
    }

    table td::before {
        /*
        * aria-label has no advantage, it won't be read inside a table
        content: attr(aria-label);
        */
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
    }

    table td:last-child {
        border-bottom: 0;
    }
}

.cursor {
    cursor: pointer;
}

.button-voltar {
    background-color: #b8ab39;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

.button-select-date {
    background-color: white;
    color: black;
    padding: 5px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 13px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    width: 100%;
    margin: 4px 2px;
    cursor: pointer;
}

.button-select-date-focused {
    background-color: white;
    color: black;
    padding: 5px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 13px;
    border-radius: 5px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    width: 100%;
    margin: 4px 2px;
    cursor: pointer;
    -webkit-box-shadow: 0 0 2px 1px rgba(255, 169, 0, 0.9);
    -moz-box-shadow: 0 0 2px 1px rgba(255, 169, 0, 0.9);
    box-shadow: 0 0 3px 1px rgba(255, 169, 0, 0.9);
}

.button {
    background-color: #4caf50;
    border: none;
    color: white;
    padding: 5px 20px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 17;
    border-radius: 5px;
    width: 100%;
    margin: 4px 2px;
    cursor: pointer;
}

.button-exit {
    background-color: #a67e21;
    border: none;
    color: white;
    padding: 15px 32px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
}

body {
    font-family: Verdana, Geneva, sans-serif;
    font-size: 14px;
    background: #f2f2f2;
}

.clearfix:after {
    content: "";
    display: block;
    clear: both;
    visibility: hidden;
    height: 0;
}

.form_wrapper {
    width: 500px;
    max-width: 100%;
    box-sizing: border-box;
    padding: 15px;
    margin: 0% auto 0;
    position: relative;
    z-index: 1;
}

.form_container {
    padding: 15px;
}

.form_wrapper h2 {
    font-size: 1.5em;
    line-height: 1.5em;
    margin: 0;
}

.form_wrapper .title_container {
    text-align: center;
    margin: -15px -15px 15px;
    padding: 15px 0;
}

.form_wrapper h3 {
    font-size: 1.1em;
    font-weight: normal;
    line-height: 1.5em;
    margin: 0;
}

.form_wrapper .row {
    margin: 10px -15px;
}

.form_wrapper .row>div {
    padding: 0 15px;
    box-sizing: border-box;
}

.form_wrapper .col_half {
    width: 50%;
    float: left;
}

.form_wrapper .col_full {
    width: 100%;
    float: left;
}

.form_wrapper .col_three {
    width: 33%;
    float: left;
}

.form_wrapper .col_four {
    width: 25%;
    float: left;
}

.form_wrapper label {
    display: block;
    margin: 0 0 5px;
}

.form_wrapper .input_field,
.form_wrapper .textarea_field {
    position: relative;
}

.form_wrapper .input_field>span,
.form_wrapper .textarea_field>span {
    position: absolute;
    left: 0;
    top: 0;
    color: #333;
    height: 100%;
    text-align: center;
    width: 20px;
}

.form_wrapper .textarea_field>span {
    max-height: 35px;
}

.input_field {
    font-size: 12px;
}

.form_wrapper .input_field>span>i,
.form_wrapper .textarea_field>span>i {
    padding-top: 5px;
}

.form_wrapper input[type="text"],
.form_wrapper input[type="date"],
.form_wrapper input[type="email"],
.form_wrapper input[type="tel"],
textarea {
    width: 100%;
    padding: 6px 6px 6px 35px;
    border: 1px solid #ccc;
    box-sizing: border-box;
    outline: none;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.form_wrapper textarea {
    height: 8em;
}

.form_wrapper input[type="text"]:focus,
.form_wrapper input[type="date"]:focus,
.form_wrapper input[type="email"]:focus,
.form_wrapper input[type="tel"]:focus,
textarea:focus {
    -webkit-box-shadow: 0 0 2px 1px rgba(255, 169, 0, 0.5);
    -moz-box-shadow: 0 0 2px 1px rgba(255, 169, 0, 0.5);
    box-shadow: 0 0 2px 1px rgba(255, 169, 0, 0.5);
    border: 1px solid #f5ba1a;
}

.form_wrapper input[type="submit"] {
    height: 50px;
    line-height: 50px;
    width: 100%;
    border: none;
    outline: none;
    cursor: pointer;
    color: #fff;
    font-size: 1.2em;
    -webkit-transition: all 0.3s ease-in-out;
    -moz-transition: all 0.3s ease-in-out;
    -ms-transition: all 0.3s ease-in-out;
    transition: all 0.3s ease-in-out;
}

.form_wrapper input[type="submit"]:hover,
.form_wrapper input[type="submit"]:focus {
    background: #daa106;
}

.credit {
    position: relative;
    z-index: 1;
    text-align: center;
    padding: 15px;
    color: #f5ba1a;
}

.credit a {
    color: #daa106;
}

@media (max-width: 600px) {

    .form_wrapper .col_half,
    .form_wrapper .col_three,
    .form_wrapper .col_four {
        width: 100%;
        float: none;
    }

    .form_wrapper label {
        margin: 10px 0;
    }
}
</style>
    
    