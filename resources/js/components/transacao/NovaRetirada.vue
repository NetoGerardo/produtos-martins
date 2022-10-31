<template>
    <div>
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />

        <div class="modal fade" id="nova-retirada-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <form @submit.prevent>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4>Registrar Saída</h4>
                            <br />
                            <div class="form-group">
                                <label for="email">Valor</label>
                                <input class="form-control" id="nome" type="text" v-model="valor" autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <label for="user_type">Tag</label>
                                <select class="form-control" id="user_type" v-model="tag">
                                    <option value="SAQUE">Saque</option>
                                    <option value="Custos operacionais">Custos operacionais</option>
                                    <option value="Pagamento de contas">Pagamento de contas</option>
                                    <option value="Pagamento de parceiros">Pagamento de parceiros</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="user_type">Selecione um projeto</label>
                                <select class="form-control" v-model="projeto">
                                    <option value=""></option>
                                    <option v-for="projeto in projetos" :key="projeto" :value="projeto">
                                        {{ projeto.nome }}
                                    </option>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="email">Descrição</label>
                                <input class="form-control" id="nome" type="text" v-model="descricao"
                                    autocomplete="name" />
                            </div>

                            <button @click="create()" class="btn btn-primary btn-flat">
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
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {

    mixins: [sweetAlert, Swal],

    components: [Loading],

    data() {
        return {
            projeto: "",
            valor: 0,
            descricao: "",
            tipo_produto: "",
            isLoading: false,
            tipo: "SAIDA",
            tag: "",
            projetos: ""
        };
    },

    mounted() {
        this.buscarProjetos();
    },

    methods: {
        validateFields() {
            if (!this.nome) {
                this.showErrorMessageWithButton("Ops...", "O campo nome é obrigatório!");
            } else {
                this.create();
            }
        },

        buscarProjetos() {
            axios
                .get(`/user/projetos/all`)
                .then((response) => {
                    this.projetos = response.data.projetos;
                    console.log("New trn");
                    console.log(this.projetos);
                })
                .catch((error) => {
                    this.showErrorMessageWithButton("Ops..", error);
                    console.log(error);
                });
        },

        create() {
            this.isLoading = true;

            let data = {
                valor: this.valor,
                descricao: this.descricao,
                projeto_id: this.projeto.id,
                tag: this.tag,
                tipo: this.tipo
            };

            console.log("CRIANDO");
            console.log(data);

            axios
                .post(`/user/transacoes/store`, data)
                .then((response) => {

                    this.showSuccessMessage("Transação cadastrada!");

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

