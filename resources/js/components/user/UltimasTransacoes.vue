<template>
  <div class="row " style="margin-top: 2%">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Últimas Transações</h4>
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
                <tr v-for="transacao in transacoes" :key="transacao" :value="transacao">
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
</template>

<script>
import sweetAlert from "../controller/sweetAlert";
import moment from "moment";
import Swal from "sweetalert2/dist/sweetalert2.js";

export default {
  mixins: [sweetAlert, Swal],

  props: ['transacoes'],

  data() {
    return {
      total_transacoes: 0,
      vendas_hoje: 0,
      entradas: 0,
      saidas: 0,
    };
  },

  mounted() {
    console.log("TRN");
    console.log(this.transacoes);
  },

  methods: {

    getUrl(telefone) {
      return "https://api.whatsapp.com/send?phone=" + telefone;
    },

    converterCNPJ(possui_cnpj) {
      if (possui_cnpj == 0) {
        return "Não";
      } else {
        return "Sim";
      }
    },

    formatDate(date) {
      return moment(date).format("DD/MM/YYYY HH:mm:ss");
    },

    confirmarNegativo(lead) {
      let html = "Acrescente um comentário à sua avaliação <b style='color:red'> Negativa?</b>";

      this.$swal
        .fire({
          title: "Confirmação",
          html: html,
          icon: "info",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Confirmar",
          input: 'text',
          inputAttributes: {
            autocapitalize: 'off',
            required: false
          },
          inputValidator: (value) => {
            if (!value) {
              return 'Coloque uma justificativa!'
            }
            else {
              this.confirmar(lead, value, "NEGATIVA")
            }
          }
        })
    },

    confirmarPositivo(lead) {
      let html = "Que bom! Deseja acrescentar algum comentário à sua avaliação <b style='color:green'> Positiva?</b>";

      this.$swal
        .fire({
          title: "Confirmação",
          html: html,
          icon: "info",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          cancelButtonColor: "#d33",
          confirmButtonText: "Confirmar",
          input: 'text',
          inputAttributes: {
            autocapitalize: 'off',
          },
        })
        .then(result => {
          if (result.isConfirmed) {
            this.confirmar(lead, result.value, "POSITIVA");
          }
        });
    },

    confirmar(lead, comentario, avaliacao) {
      let data = {
        lead_id: lead.id,
        comentario: comentario,
        avaliacao: avaliacao
      }

      axios
        .post(`/user/leads/avaliar`, data)
        .then((response) => {
          this.showSuccessMessage("Lead avaliado!");
        })
        .catch((error) => {
          this.showErrorMessageWithButton("Ops..", error.response.data);
          console.log(error.response.data);
        });
    },
  },
};
</script>
