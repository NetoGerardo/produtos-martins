<template>
    <div>
        <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />

        <div class="modal fade" id="nova-venda-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
            aria-hidden="true">
            <form @submit.prevent>
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                                &times;
                            </button>
                            <h4>Nova Venda</h4>
                            <br />
                            <div class="form-group">
                                <label for="user_type">Selecione o produto</label>
                                <select class="form-control" v-model="produto">
                                    <option value=""></option>
                                    <option v-for="produto in produtos" :key="produto" :value="produto">
                                        {{ produto.nome }}
                                    </option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="email">Quantidade vendida</label>
                                <input class="form-control" id="nome" type="number" v-model="quantidade"
                                    autocomplete="0" />
                            </div>
                            <div class="form-group">
                                <label for="email">Comprador</label>
                                <input class="form-control" id="nome" type="text" v-model="comprador"
                                    autocomplete="name" />
                            </div>
                            <div class="form-group">
                                <label for="email">Valor da venda</label>
                                <input class="form-control" id="nome" type="number" v-model="valor_venda"
                                    autocomplete="0" />
                            </div>
                            <div class="form-group">
                                <label for="email">Observação</label>
                                <input class="form-control" id="nome" type="text" v-model="observacao"
                                    autocomplete="name" />
                            </div>
                            <button @click="registrarVenda()" class="btn btn-primary btn-flat">
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
            produtos: "",
            produto: "",
            quantidade: 0,
            valor_venda: 0,
            observacao: "",
        };
    },

    mounted() {
        this.buscarProdutos();
    },

    methods: {
        validateFields() {
            if (!this.nome) {
                this.showErrorMessageWithButton("Ops...", "O campo nome é obrigatório!");
            } else {
                this.create();
            }
        },

        registrarVenda() {

            let data = {
                produto_id: this.produto.id,
                quantidade: this.quantidade,
                comprador: this.comprador,
                valor_venda: this.valor_venda,
                observacao: this.observacao
            }

            axios
                .post(`/user/vendas/store`, data)
                .then((response) => {
                    this.showSuccessMessage("Venda registrada!");

                    window.location.reload();
                })
                .catch((error) => {
                    this.showErrorMessageWithButton("Ops..", error);
                    console.log(error);
                });
        },

        buscarProdutos() {
            axios
                .get(`/user/produtos/all`)
                .then((response) => {
                    this.produtos = response.data.produtos;
                    console.log("RESULTADO");
                    console.log(response.data);
                })
                .catch((error) => {
                    this.showErrorMessageWithButton("Ops..", error);
                    console.log(error);
                });
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

