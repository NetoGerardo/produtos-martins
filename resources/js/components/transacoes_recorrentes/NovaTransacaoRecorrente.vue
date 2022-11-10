<template>
    <div>
        <load v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />
        <button data-toggle="modal" data-target="#login-modal" type="button" class="btn btn-info">
            Nova Transação Recorrente<i class="mdi mdi-plus"></i>
        </button>

        <div class="modal fade" id="login-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <form @submit.prevent>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4>Nova Transação Recorrente</h4>
                            <br />

                            <div class="form-group">
                                <label for="email">Nome</label>
                                <input class="form-control" id="nome" type="text" v-model="nome" autocomplete="name" />
                            </div>

                            <div class="form-group">
                                <label for="email">Valor</label>
                                <input class="form-control" id="nome" type="text" v-model="valor" autocomplete="name" />
                            </div>

                            <div class="form-group">
                                <label for="user_type">Tipo de transação</label>
                                <select class="form-control" id="user_type" v-model="tipo">
                                    <option value="ENTRADA">Entrada</option>
                                    <option value="SAIDA">Saída</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="user_type">Período</label>
                                <select class="form-control" id="user_type" v-model="periodo">
                                    <option value="7">Semanal</option>
                                    <option value="14">Quinzenal</option>
                                    <option value="30">Mensal</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="user_type">Data Primeira Transação</label>
                                <input class="form-control" id="dataInicio" name="dataInicio" type="date"
                                    v-model="data_primeira_transacao" />
                            </div>

                            <div class="form-group">
                                <label for="user_type">Tag</label>
                                <select class="form-control" id="user_type" v-model="tag">
                                    <option value="Transação de Venda">Transação de Venda</option>
                                    <option value="Novo Contrato">Novo Contrato</option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="email">Descrição</label>
                                <input class="form-control" id="nome" type="text" v-model="descricao"
                                    autocomplete="name" />
                            </div>

                            <div class="form-group">
                                <label for="user_type">Selecione um projeto</label>
                                <select class="form-control" v-model="projeto_selecionado">
                                    <option value=""></option>
                                    <option v-for="projeto in projetos" :key="projeto" :value="projeto">
                                        {{ projeto.nome }}
                                    </option>
                                </select>
                            </div>

                            <button @click="validateFields()" class="btn btn-primary btn-flat">
                                Cadastrar <i class="fa fa-search"></i>
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
import moment from "moment";
import Load from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {

    mixins: [sweetAlert, Swal],

    components: [Load],

    props: ['categorias', 'projetos'],

    data() {
        return {
            nome: "",
            valor: "",
            tipo: "",
            tag: "",
            descricao: "",
            projeto: "",
            periodo: "",
            dia_do_mes: "",
            data_primeira_transacao: "",
            projeto_selecionado: "",
            isLoading: false,
        };
    },

    mounted() { },

    methods: {
        validateFields() {
            if (!this.nome) {
                this.showErrorMessageWithButton("Ops...", "O campo nome é obrigatório!");
            } else {
                this.create();
            }
        },

        buscarProximaData() {

            let dataInicio = new Date(this.data_primeira_transacao);

            //ADICIONANDO 1 DIA DEVIDO AO BUG NA INTERFACE QUE TRAZ UM DIA A MENOS
            dataInicio.setDate(dataInicio.getDate() + 1);

            if (Number(this.periodo) < 30) {
                dataInicio.setDate(dataInicio.getDate() + Number(this.periodo));
            } else {

                let day = dataInicio.getDate();

                if (day >= 30) {
                    dataInicio = moment(dataInicio, "MM/DD/YYYY").add(1, 'M').endOf("month");
                } else {
                    dataInicio.setMonth(dataInicio.getMonth() + 1);
                }

            }

            return this.formatSelectedDate(dataInicio);

        },

        buscarDiaDoMes() {

            let dataInicio = new Date(this.data_primeira_transacao);

            //ADICIONANDO 1 DIA DEVIDO AO BUG NA INTERFACE QUE TRAZ UM DIA A MENOS
            dataInicio.setDate(dataInicio.getDate() + 1);

            return dataInicio.getDate();

        },

        formatSelectedDate(date) {
            return moment(date).format("yyyy-MM-DD");
        },

        formatSelectedDate(date) {
            return moment(date).format("yyyy-MM-DD");
        },

        create() {
            this.isLoading = true;

            let data_proxima_transacao = this.buscarProximaData();

            let data = {
                valor: this.valor,
                nome: this.nome,
                tipo: this.tipo,
                tag: this.tag,
                descricao: this.descricao,
                projeto_selecionado: this.projeto_selecionado.id,
                periodo: this.periodo,
                dia_do_mes: this.buscarDiaDoMes(),
                data_primeira_transacao: this.data_primeira_transacao,
                data_proxima_transacao: data_proxima_transacao
            };

            console.log("CRIANDO");
            console.log(data);

            axios
                .post(`/user/transacoes_recorrentes/store`, data)
                .then((response) => {
                    console.log("Usuário criado!");
                    console.log(response);

                    this.showSuccessMessage("Produto cadastrado!");

                    window.location.reload();
                })
                .catch((error) => {
                    this.showErrorMessageWithButton("Ops..", error);
                    console.log(error);
                });

        },
    },
};
</script>

