<script>

import { mapActions, mapGetters } from 'vuex'
import api from '../service/api';

export default {
    name: 'Companies',
    data () {
        return {
            showDialog: false,
            companyData: {
                company_name: null,
                status: null,
                user_id: null
            },
            method: null,
            statuses: [{ name: 'Активен' }, { name: 'В ожидании' }, { name: 'В архиве' }]
        }
    },
    mounted () {
        api.get('/api/companies').then(value => this.saveCompanies(value.data.data))
    },
    computed: {
        ...mapGetters(['companies', 'loading', 'userList'])
    },
    methods: {
        ...mapActions([
            'saveCompanies',
            'pushCompany',
            'showError',
            'deleteCompanyById',
            'replaceCompany',
            'saveUserList'
        ]),

        addCompany () {
            this.method = 'create';
            this.showDialog = true;
        },

        updateCompany(id) {
            this.method = 'update';
            api.get(`/api/companies/${id}`).then(value => this.companyData = value.data.data);
            this.showDialog = true;
        },

        cancelAddingCompany(event) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы действительно хотите отменить процесс добавления компании?`,
                header: 'Подтверждение отмены',
                accept: () => {
                    this.resetCompanyData();
                },
                onHide: () => {},
                acceptClass: 'p-button-success p-button-outlined',
                rejectClass: 'p-button-danger p-button-text'
            })
        },

        addCompanyHandle(event) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы собираетесь добавить компанию, действительно хотите продолжить?`,
                header: 'Подтверждение добавления',
                accept: () => {
                    api.post('/api/companies', this.companyData).then(value => {
                        this.pushCompany(value.data.data);
                        this.$notification.success('Компания добавлена');
                        this.resetCompanyData();
                    })
                },
                onHide: () => {},
                acceptClass: 'p-button-success p-button-outlined',
                rejectClass: 'p-button-danger p-button-text '
            })
        },

        updateCompanyHandle(event) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы собираетесь изменить данные компании, действительно хотите продолжить?`,
                header: 'Подтверждение редактирования',
                accept: () => {
                    api.put(`/api/companies/${this.companyData.id}`, this.companyData)
                            .then(value => {
                                this.$notification.success('Данные компании обновлены');
                                this.replaceCompany(value.data.data);
                                this.resetCompanyData();

                            })
                },
                onHide: () => {},
                acceptClass: 'p-button-success p-button-outlined',
                rejectClass: 'p-button-danger p-button-text '
            })
        },

        deleteCompany(event, id) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы действительно хотите удалить компанию?`,
                header: 'Подтверждение удаления',
                accept: () => {
                    api.delete(`/api/companies/${id}`)
                            .then(value => {
                                this.deleteCompanyById(value.data.data);
                                this.$notification.success('Компания удалена');
                            })
                },
                onHide: () => {},
                acceptClass: 'p-button-success p-button-outlined',
                rejectClass: 'p-button-danger p-button-text '
            })
        },

        resetCompanyData() {
            this.companyData = {
                company_name: null,
                status: null,
                user_id: null,
            };
            this.method = null;
            this.showDialog = false;
        },

        showDialogHandler() {
            api.get('/api/users/list').then(result => this.saveUserList(result.data.data));
        },

        getChipColor(status) {
            switch (status) {
                case 'В архиве': return { background: 'lightgray', color: 'white'  };
                case 'Активен': return { background: 'lightgreen', color: 'white' };
                case 'В ожидании': return { background: 'lightblue', color: 'white'};
                default: return '';
            }
        }
    },
}
</script>

<template>
    <Dialog v-model:visible="showDialog" :style="{ width: '40vw'}" modal @show="showDialogHandler">
        <template #header>
            <div class="text-4xl" v-if="method === 'create'">Добавление компании</div>
            <div class="text-4xl" v-else-if="method === 'update'">Редактирование компании</div>
        </template>

        <div class="gap-2 w-full">

            <div class="field w-full">
                <label for="company_name">Название</label>
                <InputText id="company_name" class="w-full" v-model="companyData.company_name" :loading="loading" fluid></InputText>
            </div>

            <div class="field w-full">
                <label for="name">Статус</label>
                <Select v-model="companyData.status" :options="statuses" optionValue="name" optionLabel="name" class="w-full"></Select>
            </div>

            <div class="field w-full">
                <label for="password">Создатель</label>
                <Select class="w-full" v-model="companyData.user_id" :options="userList" optionValue="id" optionLabel="name" filter></Select>

            </div>

        </div>

        <template #footer>
            <Button label="Отменить" text severity="danger" @click="cancelAddingCompany" :loading="loading" autofocus/>
            <Button label="Сохранить" v-if="method === 'create'" outlined severity="success" :loading="loading" @click="addCompanyHandle" autofocus/>
            <Button label="Сохранить" v-else-if="method === 'update'" outlined severity="success" :loading="loading" @click="updateCompanyHandle" autofocus/>
        </template>

    </Dialog>
    <Card class="p-card shadow-2 p-2 flex flex-column gap-2">

        <template #header>
            <div class="text-3xl m-2">Компании</div>
        </template>

        <template #content>
            <DataTable :value="companies" :loading="loading">
                <template #empty>Нет данных для отображения</template>
                <template #header>
                    <Toolbar>
                        <template #start>
                            <Button text outlined icon="pi pi-plus" severity="success" @click="addCompany"></Button>
                        </template>
                    </Toolbar>
                </template>
                <Column field="id" header="ID" />
                <Column field="company_name" header="Название компании" />
                <Column field="status" header="Статус">
                    <template #body="slot">
                        <div><Chip :label="slot.data.status" :style="getChipColor(slot.data.status)" /></div>
                    </template>
                </Column>
                <Column header="Владелец" field="user.name"></Column>
                <Column>
                    <template #body="slot">
                        <div class="flex flex-row gap-2">
                            <Button severity="warn" icon="pi pi-pencil" outlined text
                                    @click="updateCompany(slot.data.id)"></Button>
                            <Button severity="danger" icon="pi pi-trash" outlined text
                                    @click="deleteCompany($event, slot.data.id)"></Button>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </template>
    </Card>

</template>

<style scoped>

</style>