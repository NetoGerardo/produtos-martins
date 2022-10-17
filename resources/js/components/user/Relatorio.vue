<template>

  <div class="table-responsive">
    <table id="zero_config" class="table table-striped table-bordered no-wrap">
      <thead>
        <tr>
          <th>Nome</th>
          <th>CNPJ?</th>
          <th>Data</th>
          <th>Bairro</th>
          <th>Ocupação</th>
          <th>WhatsApp</th>
          <th>Avaliação</th>
          <th>Status</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="lead in leads" :key="lead" :value="lead">
          <td>{{lead.nome}}</td>

          <td data-label="Possui Cnpj?">
            {{ converterCNPJ(lead.possui_cnpj) }}
          </td>

          <td data-label="Data">
            {{ formatDate(lead.created_at) }}
          </td>

          <td>{{lead.bairro}}</td>

          <td>{{lead.ocupacao}}</td>

          <td><a :href=getUrl(lead.telefone) class="float" target="_blank">
              <img alt="Avatar" class="table-avatar" style="width:20px;opacity: .8"
                src="/assets/images/whats-logo.png" /></a>
            {{lead.telefone}}
          </td>

          <td v-if="!lead.data_avaliacao">
            <button style="width:50%" @click="confirmarPositivo(lead)" type="button" class="btn btn-success btn-sm">
              Positiva
            </button>
            <button style="width:50%" @click="confirmarNegativo(lead)" type="button" class="btn btn-danger btn-sm">
              Negativa
            </button>
          </td>

          <td v-if="lead.data_avaliacao">
            <span v-if="lead.avaliacao == 'POSITIVA'" style="color: green"
              class="badge badge-light-warning">Positiva</span>
            <span v-if="lead.avaliacao == 'NEGATIVA'" style="color: red"
              class="badge badge-light-warning">Negativa</span>
          </td>

          <td>
            <select class="form-control" id="user_type" v-model="lead.status_negociacao" @change="atualizarStatus(lead)">
              <option value=""></option>
              <option value="Em negociacao">Em negociação</option>
              <option value="Cotacao enviada">Cotação enviada</option>
              <option value="Plano adquirido">Plano adquirido</option>
              <option value="Plano adquirido">Negociação encerrada</option>
            </select>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
import sweetAlert from "../controller/sweetAlert";
import moment from "moment";
import Swal from "sweetalert2/dist/sweetalert2.js";

export default {
  mixins: [sweetAlert, Swal],

  props: ['leads'],

  data() {
    return {
      total_cadastrados: 0,
      indicacoes_recebidas: 0,
      total_positivas: 0,
      total_negativas: 0,
    };
  },

  mounted() {
    console.log(this.leads);

    for (let i = 0; i < this.leads.length; i++) {
      if (this.leads[i].origem_lead == 'CADASTRO MANUAL') {
        this.total_cadastrados++;
      } else {
        this.indicacoes_recebidas++;
      }

      if (this.leads[i].data_avaliacao) {
        if (this.leads[i].avaliacao == 'POSITIVA') {
          this.total_positivas++;
        } else {
          this.total_negativas++;
        }
      }
    }
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

    atualizarStatus(lead) {
      let data = {
        lead_id: lead.id,
        status: lead.status_negociacao,
      }

      axios
        .post(`/user/leads/status/update`, data)
        .then((response) => {
          this.showSuccessMessage("Status atualizado!");
        })
        .catch((error) => {
          this.showErrorMessageWithButton("Ops..", error.response.data);
          console.log(error.response.data);
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
