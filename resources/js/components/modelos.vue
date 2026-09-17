<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">

                <!--Inicio do car de busca-->
                <card-component titulo="Busca de marcas">
                    <template v-slot:conteudo>
                        <div class="row">
                            <div class="col-md-6">
                                <input-container-component titulo="ID" id="inputId" id-help="idHelp"
                                                           texto-ajuda="Opcional. Informe o ID do modelo">
                                    <input type="number" class="form-control" id="inputId" aria-describedby="idHelp"
                                           placeholder="ID" v-model="buscas.id">
                                </input-container-component>
                            </div>
                            <div class="col-md-6">
                                <input-container-component titulo="Nome do modelo" id="inputNome" id-help="nomeHelp"
                                                           texto-ajuda="Opcional. Informe o Nome do modelo">
                                    <input type="text" class="form-control" id="inputNome" aria-describedby="nomeHelp"
                                           placeholder="Nome do modelo" v-model="buscas.nome">
                                </input-container-component>
                            </div>
                        </div>
                    </template>

                    <template v-slot:rodape>
                        <button type="submit" class="btn btn-primary btn-sm float-lg-end" @click="pesquisar()">
                            Pesquisar
                        </button>
                    </template>
                </card-component>
                <!--FIM do car de busca-->

                <!--Inicio do card de listagem de modelos-->
                <card-component titulo="Relação de Modelos">
                    <template v-slot:conteudo>
                        <table-component
                            :dados="marcas.data"
                            :visualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaVisualizar'}"
                            :atualizar="{visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaAtualizar'}"
                            :remover="{visivel: true, dataToggle: 'modal', dataTarget: '#modalMarcaRemover'}"
                            :titulos="{
                                id: {titulo: 'ID', tipo: 'text'},
                                marca_id: {titulo: 'Marca', tipo: 'text'},
                                nome: {titulo: 'Nome', tipo: 'text'},
                                imagem: {titulo: 'Imagem', tipo: 'imagem'},
                                numero_portas: {titulo: 'Portas', tipo: 'text'},
                                lugares: {titulo: 'Lugares', tipo: 'text'},
                                airbag: {titulo: 'Airbag', tipo: 'text'},
                                abs: {titulo: 'ABS', tipo: 'text'},
                                created_at: {titulo: 'Data de criação', tipo: 'data'},
                                updated_at: {titulo: 'Data de atualização', tipo: 'data'},
                            }"
                        ></table-component>
                    </template>

                    <template v-slot:rodape>
                        <div class="row">
                            <div class="col-10">
                                <pagination-component>
                                    <li v-for="(l, key) in marcas.links" :key="key"
                                        :class="l.active ? 'page-item active' : 'page-item'"
                                        @click="paginacao(l)">
                                        <a class="page-link" v-html="l.label"></a>
                                    </li>
                                </pagination-component>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-primary btn-sm float-lg-end" data-bs-toggle="modal"
                                        data-bs-target="#modalMarca">Adicionar
                                </button>
                            </div>
                        </div>
                    </template>
                </card-component>
                <!--FIM do car de listagem de marcas-->

            </div>
        </div>

        <!--Início modal de inclusão de marcas-->
        <modal-component id="modalModelo" titulo="Adicionar Modelo">

            <template v-slot:alerta>
                <alert-component tipo="success" :detalhes="transacaoDetalhes" titulo="Cadastro realizado com sucesso!"
                                 v-if="transacaoStatus == 'adicionado'"></alert-component>
                <alert-component tipo="danger" :detalhes="transacaoDetalhes" titulo="Erro ao cadastrar a marca!"
                                 v-if="transacaoStatus == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome do Modelo" id="novoNome" id-help="novoNomeHelp"
                                               texto-ajuda="Informe o nome do modelo">
                        <input type="text" class="form-control" id="novoNome" aria-describedby="novoNomeHelp"
                               placeholder="Informe o nome do modelo" v-model="nomeModelo">
                    </input-container-component>
                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="novoImagem" id-help="novoImagemHelp"
                                               texto-ajuda="Insira a imagem da marca em PNG">
                        <input type="file" class="form-control" id="novoImagem" aria-describedby="novoImagemHelp"
                               placeholder="Insira a imagem da marca em PNG" @change="carregarImagem($event)">
                    </input-container-component>
                </div>




            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="salvar()" >Salvar</button>
            </template>
        </modal-component>
        <!--FIM do modal de inclusão de marcas-->

        <!--Início do modal de visualização de marca-->
        <modal-component id="modalMarcaVisualizar" titulo="Visualizar Marca">
            <template v-slot:alerta></template>
            <template v-slot:conteudo>

                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome da marca">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>

                <input-container-component titulo="Imagem">
                    <img :src="'storage/'+$store.state.item.imagem" v-if="$store.state.item.imagem">
                </input-container-component>

                <input-container-component titulo="Data de criação">
                    <input type="text" class="form-control" :value="$store.state.item.created_at" disabled>
                </input-container-component>

            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </template>
        </modal-component>
        <!--Final do modal de visualização de marca-->

        <!--Início do modal de remoção de marca-->
        <modal-component id="modalMarcaRemover" titulo="Remover Marca">
            <template v-slot:alerta>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo v-if="$store.state.transacao.status != 'sucesso'">
                <input-container-component titulo="ID">
                    <input type="text" class="form-control" :value="$store.state.item.id" disabled>
                </input-container-component>

                <input-container-component titulo="Nome da marca">
                    <input type="text" class="form-control" :value="$store.state.item.nome" disabled>
                </input-container-component>

            </template>
            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-danger" @click="remover()" v-if="$store.state.transacao.status != 'sucesso'">Remover</button>
            </template>
        </modal-component>
        <!--Final do modal de remoção de marca-->

        <!--Início modal de Atualização de marcas-->
        <modal-component id="modalMarcaAtualizar" titulo="Atualizar Marca">
            <template v-slot:alerta>
                <alert-component tipo="success" titulo="Transação realizada com sucesso" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'sucesso'"></alert-component>
                <alert-component tipo="danger" titulo="Erro na transação" :detalhes="$store.state.transacao" v-if="$store.state.transacao.status == 'erro'"></alert-component>
            </template>

            <template v-slot:conteudo>
                <div class="form-group">
                    <input-container-component titulo="Nome da marca" id="atualizarNome" id-help="atualizarNomeHelp"
                                               texto-ajuda="Informe o nome da marca">
                        <input type="text" class="form-control" id="atualizarNome" aria-describedby="atualizarNomeHelp"
                               placeholder="Informe o nome da marca" v-model="$store.state.item.nome">
                    </input-container-component>

                </div>

                <div class="form-group">
                    <input-container-component titulo="Imagem" id="atualizarImagem" id-help="atualizarImagemHelp"
                                               texto-ajuda="Insira a imagem da marca em PNG">
                        <input type="file" class="form-control" id="atualizarImagem" aria-describedby="atualizarImagemHelp"
                               placeholder="Insira a imagem da marca em PNG" @change="carregarImagem($event)">
                    </input-container-component>
                </div>
            </template>

            <template v-slot:rodape>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary" @click="atualizar()">Atualizar</button>
            </template>
        </modal-component>
        <!--FIM do modal de Atualização de marcas-->

    </div>
</template>

<script>

import Pagination from "./pagination.vue";

export default {
    components: {Pagination},
    data() {
        return {
            urlBase: "http://localhost:8000/api/v1/marca",
            urlPaginacao: '',
            urlFiltro: '',
            nome: '',
            arquivoImagem: [],
            numero_portas: '',
            lugares: '',
            air_bag: '',
            abs: '',
            transacaoStatus: '',
            transacaoDetalhes: {},
            marcas: {
                data: [],
            },
            buscas: {
                id: '',
                nome: '',
            },
        }
    },
    methods: {
        atualizar() {

            let formData = new FormData();
            formData.append('_method', 'patch')
            formData.append('nome', this.$store.state.item.nome)

            if (this.arquivoImagem[0]) {
                formData.append('imagem', this.arquivoImagem[0])
            }

            let url = this.urlBase + "/" + this.$store.state.item.id

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }

            axios.post(url, formData, config)
                .then(response => {
                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = 'Registro de marca atualizado com sucesso'
                    atualizarImagem.value = ''
                    this.carregarLista()
                })
                .catch(errors => {
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = errors.response.data.message
                    this.$store.state.transacao.dados = errors.response.data.errors
                })
        },
        remover() {
            let confirmacao = confirm('Tem certeza que gostaria de remover esse registro?')
            if (!confirmacao) {
                return false;
            }

            let formData = new FormData();
            formData.append('_method', 'delete');

            let url = this.urlBase + '/' + this.$store.state.item.id
            // let url = this.urlBase + '/1450'

            axios.post(url, formData)
                .then(response => {
                    console.log('Removido com sucesso!', response);

                    this.$store.state.transacao.status = 'sucesso'
                    this.$store.state.transacao.mensagem = response.data.msg
                    this.carregarLista()
                })
                .catch(errors => {
                    console.log('Ocorreu um erro ao remover', errors.response)
                    this.$store.state.transacao.status = 'erro'
                    this.$store.state.transacao.mensagem = errors.response.data.erro
                })
        },
        pesquisar() {
            let filtro = ''

            for (let chave in this.buscas) {
                if (this.buscas[chave]) {
                    if (filtro != '') {
                        filtro += ";"
                    }
                    filtro += chave + ':like:' + this.buscas[chave]
                }
            }
            if (filtro != '') {
                this.urlPaginacao = 'page=1'
                this.urlFiltro = '&filtro=' + filtro
            } else {
                this.urlFiltro = ''
            }
            this.carregarLista()
        },
        paginacao(l) {
            if (l.url) {
                this.urlPaginacao = l.url.split('?')[1]
                // this.urlBase = l.url
                this.carregarLista()
            }
        },
        carregarLista() {

            let url = this.urlBase + '?' + this.urlPaginacao + this.urlFiltro

            axios.get(url)
                .then(response => {
                    this.marcas = response.data
                    console.log(this.marcas);
                })
                .catch(errors => {
                    console.log(errors)
                })
        },
        carregarImagem(e) {
            this.arquivoImagem = e.target.files
        },
        salvar() {

            console.log(this.nomeMarca, this.arquivoImagem[0])

            let formData = new FormData();
            formData.append('nome', this.nomeMarca);
            formData.append('imagem', this.arquivoImagem[0]);

            let config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                }
            }

            axios.post(this.urlBase, formData, config)
                .then(response => {
                    this.transacaoStatus = 'adicionado'
                    this.transacaoDetalhes = {
                        mensagem: 'ID do registro: ' + response.data.id
                    }
                    this.carregarLista();
                    console.log(response);
                })
                .catch(errors => {
                    this.transacaoStatus = 'erro'
                    this.transacaoDetalhes = {
                        mensagem: errors.response.data.mensagem,
                        dados: errors.response.data.errors
                    }
                });
        }
    },
    mounted() {
        this.carregarLista();
    }
}
</script>
