<template>
  <div>
    <loading v-model:active="isLoading" :can-cancel="false" :is-full-page="true" />
    <button data-toggle="modal" data-target="#login-modal" type="button" class="btn btn-info">
      Novo usuário <i class="nav-icon far fa-plus-square"></i>
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
              <h4>Novo usuário</h4>
              <br />
              <div class="form-group">
                <label for="email">Nome</label>
                <input class="form-control" id="nome" type="text" v-model="nome" autocomplete="name" />
              </div>

              <div class="form-group">
                <label for="email">Email</label>
                <input class="form-control" id="email" type="email" v-model="email" autocomplete="email" />
              </div>

              <div class="form-group">
                <label for="password" class="col-md-4 col-form-label text-md-end">Senha</label>
                <input class="form-control" id="senha" type="senha" v-model="senha" autocomplete="senha" />
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
import wppController from "../controller/wppController";
import sweetAlert from "../controller/sweetAlert";
import Swal from "sweetalert2/dist/sweetalert2.js";

import Loading from "vue-loading-overlay";
import "vue-loading-overlay/dist/vue-loading.css";

export default {
  mixins: [wppController, sweetAlert, Swal],

  data() {
    return {
      container: {},
      nome: "",
      email: "",
      senha: "",
      tipo_usuario: "",
      isLoading: false,
    };
  },

  mounted() { },

  methods: {
    validateFields() {
      if (!this.nome) {
        this.showErrorMessageWithButton("Ops...", "O campo nome é obrigatório!");
      } else if (!this.validateEmail()) {
        this.showErrorMessageWithButton("Ops...", "Digite um email válido!");
      } else if (this.senha == "") {
        this.showErrorMessageWithButton("Ops...", "A senha não pode ficar em branco!");
      } else {
        this.create();
      }
    },

    create() {
      this.isLoading = true;

      let data = {
        nome: this.nome,
        email: this.email,
        senha: this.senha,
        chave: this.generateKey(),
      };

      console.log("CRIANDO");
      console.log(data);

      axios
        .post(`/admin/users/create`, data)
        .then((response) => {
          console.log("Usuário criado!");
          console.log(response);

          this.showSuccessMessage("Usuário criado!");

          window.location.reload();
        })
        .catch((error) => {
          this.showErrorMessageWithButton("Ops..", error.response.data);
          console.log(error.response.data);
        });
    },

    validateEmail() {
      if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(this.email)) {
        return true;
      } else {
        return false;
      }
    },

    generateKey() {
      return Math.random().toString(36).slice(2);
    },
  },
};
</script>

<style scoped>
.swal-modal {
  color: green;
  background-color: rgba(63, 255, 106, 0.69);
  border: 3px solid white;
}

.swal-overlay {
  background-color: rgba(43, 165, 137, 0.45);
}
</style>
