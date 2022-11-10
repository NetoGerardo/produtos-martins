require('./bootstrap');

import { createApp } from "vue";
import router from "./router";
import VueSweetalert2 from "vue-sweetalert2";
import 'sweetalert2/dist/sweetalert2.min.css';
import VueClipboard from 'vue-clipboard2'

//USER
import UserIndex from "./components/user/Index.vue";
import NovaCategoria from "./components/categoria/NovaCategoria.vue";
import ListarCategorias from "./components/categoria/ListarCategorias.vue";
import NovoProjeto from "./components/projeto/NovoProjeto.vue";
import ListarProjetos from "./components/projeto/ListarProjetos.vue";
import NovoProduto from "./components/produto/NovoProduto.vue";
import ListarProdutos from "./components/produto/ListarProdutos.vue";
import NovaVenda from "./components/venda/NovaVenda.vue";
import ListarVendas from "./components/venda/ListarVendas.vue";
import UltimasTransacoes from "./components/user/UltimasTransacoes.vue";
import NovaRetirada from "./components/transacao/NovaRetirada.vue";
import NovaTransacao from "./components/transacao/NovaTransacao.vue";
import Relatorio from "./components/user/Relatorio.vue";
import NovaTransacaoRecorrente from "./components/transacoes_recorrentes/NovaTransacaoRecorrente.vue";
import ListarTransacoesRecorrentes from "./components/transacoes_recorrentes/ListarTransacoesRecorrentes.vue";
import ListarTransacoesAguardandoPagamento from "./components/transacoes_agardando_pagamento/ListarTransacoesAguardandoPagamento.vue";

import axios from 'axios';
import VueAxios from 'vue-axios'

//OPÇÃO 3
const vue = createApp({
    components: {}
})

vue.use(VueAxios, axios)
vue.use(VueClipboard)
vue.use(VueSweetalert2);
vue.use(router)
vue.component('user-index', UserIndex)
vue.component('nova-categoria', NovaCategoria)
vue.component('listas-categorias', ListarCategorias)
vue.component('novo-projeto', NovoProjeto)
vue.component('listar-projetos', ListarProjetos)
vue.component('novo-produto', NovoProduto)
vue.component('listar-produtos', ListarProdutos)
vue.component('nova-venda', NovaVenda)
vue.component('listar-vendas', ListarVendas)
vue.component('ultimas-transacoes', UltimasTransacoes)
vue.component('nova-retirada', NovaRetirada)
vue.component('nova-transacao', NovaTransacao)
vue.component('user-relatorio', Relatorio)
vue.component('nova-transacao-recorrente', NovaTransacaoRecorrente)
vue.component('listar-transacoes-recorrente', ListarTransacoesRecorrentes)

vue.component('listar-transacoes-aguardando-pagamento', ListarTransacoesAguardandoPagamento)

vue.mount("#app")

