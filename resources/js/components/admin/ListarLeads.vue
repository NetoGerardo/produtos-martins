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
          <th>Ações</th>
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

          <td>
            <button data-toggle="modal" data-target="#enviar-modal" style="width:100%" @click="selecionarLead(lead)"
              type="button" class="btn btn-primary btn-sm">
              Encaminhar
            </button>
          </td>

        </tr>
      </tbody>
    </table>
  </div>
  <div class="modal fade" id="enviar-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <form @submit.prevent>
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
              &times;
            </button>
            <h4>Enviar Lead</h4>
            <br /><br />
            <div class="form-group">
              <label for="user_type">Corretor</label>
              <select class="form-control" id="user_type" v-model="corretor_selecionado">
                <option v-for="corretor in corretores" :key="corretor" :value="corretor">
                  {{ corretor.name }}
                </option>
              </select>
            </div>

            <button style="width:100%" @click="enviarLead()" type="button" class="btn btn-success btn-sm">
              Enviar
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import sweetAlert from "../controller/sweetAlert";
import moment from "moment";

export default {
  mixins: [sweetAlert],

  props: ['leads', 'corretores'],

  data() {
    return {
      corretor_selecionado: "",
      lead_selecionado: ""
    };
  },

  mounted() {
    console.log(this.corretores);
  },

  methods: {

    enviarLead() {
      let data = {
        lead_id: this.lead_selecionado.id,
        corretor_id: this.corretor_selecionado.id
      }

      axios
        .post(`/admin/leads/encaminhar`, data)
        .then((response) => {

          this.showSuccessMessage("Indicação encaminhada!");

          window.location.reload();
        })
        .catch((error) => {
          this.showErrorMessageWithButton("Ops..", error);
          console.log(error);
        });
    },

    selecionarLead(lead) {
      this.lead_selecionado = lead;
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
  },
};
</script>
