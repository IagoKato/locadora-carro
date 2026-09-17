import './bootstrap';
import { createApp } from 'vue';
import { createStore } from 'vuex';

const store = createStore({
    state() {
        return {
            item: {},
            transacao: {
                status: '',
                mensagem: '',
                dados: ''
            }
        }
    }
});

const app = createApp({});

app.use(store);

import ExampleComponent from './components/ExampleComponent.vue';
app.component('example-component', ExampleComponent);

import login from './components/login.vue';
app.component('login-component', login);

import home from './components/home.vue';
app.component('home-component', home);

import marcas from './components/marcas.vue';
app.component('marcas-component', marcas);

import inputContainer from './components/inputContainer.vue';
app.component('input-container-component', inputContainer);

import table from './components/table.vue';
app.component('table-component', table);

import card from './components/card.vue';
app.component('card-component', card);

import modal from './components/modal.vue';
app.component('modal-component', modal);

import alert from './components/alert.vue';
app.component('alert-component', alert);

import pagination from './components/pagination.vue';
app.component('pagination-component', pagination);

import modelos from './components/modelos.vue';
app.component('modelos-component', modelos);


// Formatação de data
app.config.globalProperties.$formataDataTempoGlobal = function (d) {

    if (!d) return '';

    d = d.split('T');

    let data = d[0];
    let tempo = d[1];

    // Data formatada
    data = data.split('-');
    data = data[2] + '/' + data[1] + '/' + data[0];

    // Tempo formatado
    tempo = tempo.split('.');
    tempo = tempo[0];

    return data + ' ' + tempo;
};


app.mount('#app');
