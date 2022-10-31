<template>
  <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />
  <div class="form_wrapper">
    <div class="form_container">
      <form @submit.prevent>
        <div class="row clearfix">
          <div class="col_half">
            <label>De</label>
            <div class="input_field">
              <input id="dataInicio" name="dataInicio" type="date" v-model="dataInicio" />
            </div>
          </div>
          <div class="col_half">
            <label>Até</label>
            <div class="input_field">
              <input id="dataFim" type="date" v-model="dataFim" />
            </div>
          </div>
        </div>
        <div class="row clearfix">
          <div class="col_three">
            <div class="input_field">
              <button v-on:click="search(1)" :class="
                period === 1 ? 'button-select-date-focused' : 'button-select-date'
              " id="dataFim">
                Hoje
              </button>
            </div>
          </div>
          <div class="col_three">
            <div class="input_field">
              <button v-on:click="search(7)" :class="
                period === 7 ? 'button-select-date-focused' : 'button-select-date'
              " id="dataFim">
                7 dias
              </button>
            </div>
          </div>
          <div class="col_three">
            <div class="input_field">
              <button v-on:click="search(15)" :class="
                period === 15 ? 'button-select-date-focused' : 'button-select-date'
              " id="dataFim">
                15 dias
              </button>
            </div>
          </div>
        </div>
        <button class="button" type="button" v-on:click="search(0)">Buscar</button>
      </form>
    </div>
  </div>

  <div class="row" style="padding: 10px 10px 10px 10px">

    <div class="col-sm-12 col-md-3">
      <div class="form-group">
        <label>Selecione um Produto</label>
        <select class="form-control" v-model="produto_selecionado" @change="search()">
          <option value=""></option>
          <option v-for="produto in produtos" :key="produto" :value="produto.id">
            {{ produto.nome }}
          </option>
        </select>
      </div>
    </div>

    <div class="col-sm-12 col-md-3">
      <div class="form-group">
        <label>Selecione um Projeto</label>
        <select class="form-control" v-model="projeto_selecionado" @change="search()">
          <option value=""></option>
          <option v-for="projeto in projetos" :key="projeto" :value="projeto.id">
            {{ projeto.nome }}
          </option>
        </select>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card" style="padding: 1% 1% 1% 1%">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <div class="d-flex align-items-center align-self-start">
                <h3 class="mb-0">R${{ total_transacoes }}</h3>
                <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p>
              </div>
            </div>
            <div class="col-3">
              <div class="icon icon-box-success ">
                <span class="mdi mdi-arrow-top-right icon-item"></span>
              </div>
            </div>
          </div>
          <h6 class="text-muted font-weight-normal">Total de Transações</h6>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card" style="padding: 1% 1% 1% 1%">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <div class="d-flex align-items-center align-self-start">
                <h3 class="mb-0">{{ total_vendas }}</h3>
                <p class="text-success ml-2 mb-0 font-weight-medium">+11%</p>
              </div>
            </div>
            <div class="col-3">
              <div class="icon icon-box-success">
                <span class="mdi mdi-arrow-top-right icon-item"></span>
              </div>
            </div>
          </div>
          <h6 class="text-muted font-weight-normal">Vendas</h6>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card" style="padding: 1% 1% 1% 1%">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <div class="d-flex align-items-center align-self-start">
                <h3 class="mb-0">R${{ entradas }}</h3>
                <p class="text-success ml-2 mb-0 font-weight-medium">+3.5%</p>
              </div>
            </div>
            <div class="col-3">
              <div class="icon icon-box-success ">
                <span class="mdi mdi-arrow-top-right icon-item"></span>
              </div>
            </div>
          </div>
          <h6 class="text-muted font-weight-normal">Entradas Hoje</h6>
        </div>
      </div>
    </div>
    <div class="col-xl-3 col-sm-6 grid-margin stretch-card" style="padding: 1% 1% 1% 1%">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-9">
              <div class="d-flex align-items-center align-self-start">
                <h3 class="mb-0">R${{ saidas }}</h3>
                <p class="text-danger ml-2 mb-0 font-weight-medium">-2.4%</p>
              </div>
            </div>
            <div class="col-3">
              <div class="icon icon-box-danger">
                <span class="mdi mdi-arrow-bottom-left icon-item"></span>
              </div>
            </div>
          </div>
          <h6 class="text-muted font-weight-normal">Saídas Hoje</h6>
        </div>
      </div>
    </div>
  </div>

  <div>
    <div class="row " style="margin-top: 2%">
      <div class="col-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <h4 class="card-title">Transações</h4>
            <div class="table-responsive">
              <table class="table">
                <thead>
                  <tr>
                    <th> Descrição</th>
                    <th> Projeto </th>
                    <th> Valor </th>
                    <th> Tag </th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="transacao in aux_transacoes" :key="transacao" :value="transacao">
                    <td>
                      <span class="pl-2">{{ transacao.descricao }}</span>
                    </td>
                    <td>{{ transacao.projeto }} </td>
                    <td>{{ transacao.valor }} </td>
                    <td>{{ transacao.tag }} </td>
                    <td v-if="transacao.tipo == 'ENTRADA'">
                      <div class="badge badge-outline-success">Entrada</div>
                    </td>
                    <td v-if="transacao.tipo == 'SAIDA'">
                      <div class="badge badge-outline-danger">Saída</div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

</template>

<script>
import sweetAlert from "../controller/sweetAlert";
import moment from "moment";
import Swal from "sweetalert2/dist/sweetalert2.js";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
  mixins: [sweetAlert, Swal],

  components: { Loading },

  props: ['soma_transacoes', 'transacoes', 'projetos', 'produtos'],

  data() {
    return {
      total_vendas: 0,
      entradas: 0,
      saidas: 0,
      dataInicio: "",
      dataFim: "",
      period: 0,
      aux_transacoes: "",
      aux_soma_transacoes: 0,
      produto_selecionado: "",
      projeto_selecionado: ""
    };
  },

  mounted() {
    console.log(this.transacoes);

    this.aux_soma_transacoes = this.soma_transacoes;
    this.aux_transacoes = this.transacoes;

    //DEFININDO DATA DE HOJE
    this.dataInicio = new Date();
    this.dataInicio = this.formatSelectedDate(this.dataInicio);

    //DEFININDO DATA DE HOJE
    this.dataFim = new Date();
    this.dataFim = this.formatSelectedDate(this.dataFim);

    this.calcularTotais();
  },

  methods: {

    calcularTotais() {
      this.total_transacoes = this.somarTransacoes();

      if (this.aux_soma_transacoes) {
        this.total_vendas = this.aux_soma_transacoes.total_vendas;
        this.entradas = this.aux_soma_transacoes.entradas;
        this.saidas = this.aux_soma_transacoes.saidas;
      } else {
        this.total_vendas = 0;
        this.entradas = 0;
        this.saidas = 0;
      }

    },

    somarTransacoes() {

      let total = 0;

      for (let i = 0; i < this.aux_transacoes.length; i++) {
        if (this.aux_transacoes[i].tipo == 'ENTRADA') {
          total = total + parseFloat(this.aux_transacoes[i].valor);
        } else if (this.aux_transacoes[i].tipo == 'SAIDA') {
          total = total - parseFloat(this.aux_transacoes[i].valor);
        }
      }

      return total;
    },

    search(number) {
      this.isLoading = true;

      this.period = number;

      if (this.period == 1) {

        //DEFININDO DATA DE HOJE
        this.dataInicio = new Date();
        this.dataInicio = this.formatSelectedDate(this.dataInicio);


        //DEFININDO DATA DE HOJE
        this.dataFim = new Date();
        this.dataFim = this.formatSelectedDate(this.dataFim);
      } else if (this.period > 0) {

        //DEFININDO DATA DE HOJE
        this.dataFim = new Date();
        this.dataFim = this.formatSelectedDate(this.dataFim);

        //DEFININDO DATA DE ACORDO COM O PERIODO
        let dataHoje = new Date();
        dataHoje.setDate(dataHoje.getDate() - this.period);
        this.dataInicio = this.formatSelectedDate(dataHoje);
      }

      let aux_dataInicio = this.formatDateToSearch(this.dataInicio);
      let aux_dataFim = this.formatDateToSearchTime(this.dataFim);

      let data = {
        data_inicio: aux_dataInicio,
        data_fim: aux_dataFim,
        projeto_id: this.projeto_selecionado,
        produto_id: this.produto_selecionado
      }

      console.log("Enviando");
      console.log(data);

      axios
        .post(`/user/relatorio/search`, data)
        .then((response) => {

          this.aux_soma_transacoes = response.data.soma_transacoes;
          this.aux_transacoes = response.data.transacoes;

          this.calcularTotais();
          this.isLoading = false;

        })
        .catch((error) => {
          this.showErrorMessageWithButton("Ops..", error.response.data);
          console.log(error.response.data);
        });
    },

    formatDate(date) {
      return moment(date).format("DD/MM/YYYY HH:mm:ss");
    },

    formatSelectedDate(date) {
      return moment(date).format("yyyy-MM-DD");
    },

    formatDateToSearch(date) {
      return moment(date).format("yyyy-MM-DD 00:00:00");
    },

    formatDateToSearchTime(date) {
      return moment(date).format("yyyy-MM-DD 23:59:59");
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
