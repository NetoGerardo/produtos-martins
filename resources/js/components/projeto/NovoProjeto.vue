<template>
    <div>
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />
        <button data-toggle="modal" data-target="#login-modal" type="button" class="btn btn-info">
            Nova Categoria <i class="mdi mdi-plus"></i>
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
                            <h4>Novo Projeto</h4>
                            <br />
                            <div class="form-group">
                                <label for="email">Nome</label>
                                <input class="form-control" id="nome" type="text" v-model="nome" autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <label for="email">Descrição</label>
                                <input class="form-control" id="nome" type="text" v-model="descricao"
                                    autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <label for="user_type">Tipo de produto</label>
                                <select class="form-control" id="user_type" v-model="tipo_produto">
                                    <option value="fisico">Físico</option>
                                    <option value="servico">Serviço</option>
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
import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {

    mixins: [sweetAlert, Swal],

    components: [Loading],

    data() {
        return {
            nome: "",
            descricao: "",
            tipo_produto: "",
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

        create() {
            this.isLoading = true;

            let data = {
                nome: this.nome,
                descricao: this.descricao,
                tipo_produto: this.tipo_produto
            };

            console.log("CRIANDO");
            console.log(data);

            axios
                .post(`/user/projetos/store`, data)
                .then((response) => {
                    console.log("Usuário criado!");
                    console.log(response);

                    this.showSuccessMessage("Projeto criado!");

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

