<template>
    <div>
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />
        <button data-toggle="modal" data-target="#login-modal" type="button" class="btn btn-info">
            Novo Produto <i class="mdi mdi-plus"></i>
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
                            <h4>Novo Produto</h4>
                            <br />
                            <div class="form-group">
                                <label for="email">Nome</label>
                                <input class="form-control" id="nome" type="text" v-model="nome" autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <label for="email">Quantidade</label>
                                <input class="form-control" id="nome" type="text" v-model="quantidade"
                                    autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <label for="email">Valor de compra</label>
                                <input class="form-control" id="nome" type="text" v-model="valor_compra"
                                    autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <label for="email">Valor de venda</label>
                                <input class="form-control" id="nome" type="text" v-model="valor_venda"
                                    autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <label for="user_type">Selecione uma categoria</label>
                                <select class="form-control" v-model="categoria">
                                    <option value=""></option>
                                    <option v-for="categoria in categorias" :key="categoria" :value="categoria">
                                        {{ categoria.nome }}
                                    </option>
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

    props: ['categorias', 'projetos'],

    components: [Loading],

    data() {
        return {
            nome: "",
            descricao: "",
            tipo_produto: "",
            isLoading: false,
            quantidade: 0,
            valor_compra: 0,
            valor_venda: 0,
            categoria: "",
            projeto: "",
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
                quantidade: this.quantidade,
                valor_compra: this.valor_compra,
                valor_venda: this.valor_venda,
                categoria: this.categoria,
                tipo_produto: this.tipo_produto,
                projeto_id: this.projeto.id
            };

            console.log("CRIANDO");
            console.log(data);

            axios
                .post(`/user/produtos/store`, data)
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

