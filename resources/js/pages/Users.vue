<script>

import { mapActions, mapGetters } from 'vuex'
import api from '../service/api';

export default {
    name: 'Users',
    data () {
        return {
            showDialog: false,
            userData: {
                email: null,
                name: null,
                password: null,
                password_confirmation: null,
            },
            method: null
        }
    },
    mounted () {
        api.get('/api/users').then(value => this.saveUsers(value.data.data))
    },
    computed: {
        ...mapGetters(['users', 'loading'])
    },
    methods: {
        ...mapActions(['saveUsers', 'pushUser', 'showError', 'deleteUserById', 'replaceUser']),

        addUser () {
            this.method = 'create';
            this.showDialog = true;
        },

        updateUser(id) {
          this.method = 'update';
          api.get(`/api/users/${id}`).then(value => this.userData = value.data.data);
          this.showDialog = true;
        },

        cancelAddingUser(event) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы действительно хотите отменить процесс добавления пользователя?`,
                header: 'Подтверждение отмены',
                accept: () => {
                    this.resetUserData();
                },
                onHide: () => {},
                acceptClass: 'p-button-success p-button-outlined',
                rejectClass: 'p-button-danger p-button-text'
            })
        },

        addUserHandle(event) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы собираетесь добавить пользователя, действительно хотите продолжить?`,
                header: 'Подтверждение добавления',
                accept: () => {
                    api.post('/api/users', this.userData).then(value => {
                        this.pushUser(value.data.data);
                        this.$notification.success('Пользователь добавлен');
                        this.resetUserData();
                    })
                },
                onHide: () => {},
                acceptClass: 'p-button-success p-button-outlined',
                rejectClass: 'p-button-danger p-button-text '
            })
        },

        updateUserHandle(event) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы собираетесь изменить данные пользователя, действительно хотите продолжить?`,
                header: 'Подтверждение редактирования',
                accept: () => {
                    api.put(`/api/users/${this.userData.id}`, this.userData)
                            .then(value => {
                                this.$notification.success('Данные пользователя обновлены');
                                this.replaceUser(value.data.data);
                                this.resetUserData();

                            })
                },
                onHide: () => {},
                acceptClass: 'p-button-success p-button-outlined',
                rejectClass: 'p-button-danger p-button-text '
            })
        },

        deleteUser(event, id) {
            this.$confirm.require({
                target: event.currentTarget,
                message: `Вы действительно хотите удалить пользователя?`,
                header: 'Подтверждение удаления',
                accept: () => {
                    api.delete(`/api/users/${id}`)
                            .then(value => {
                                this.deleteUserById(value.data.data);
                                this.$notification.success('Пользователь удален');
                            })
                },
                onHide: () => {},
                acceptClass: 'p-button-success p-button-outlined',
                rejectClass: 'p-button-danger p-button-text '
            })
        },

        resetUserData() {
            this.userData = {
                email: null,
                name: null,
                password: null,
                password_confirmation: null,
            };
            this.method = null;
            this.showDialog = false;
        }
    },
}
</script>

<template>
    <Dialog v-model:visible="showDialog" :style="{ width: '40vw'}" modal >
        <template #header>
            <div class="text-4xl" v-if="method === 'create'">Добавление пользователя</div>
            <div class="text-4xl" v-else-if="method === 'update'">Редактирование пользователя</div>
        </template>

        <div class="gap-2 w-full">

            <div class="field w-full">
                <label for="email">Электронная почта</label>
                <InputText id="email" class="w-full" v-model="userData.email" :loading="loading" fluid></InputText>
            </div>

            <div class="field w-full">
                <label for="name">Имя</label>
                <InputText id="name" class="w-full" v-model="userData.name" :loading="loading" fluid></InputText>
            </div>

            <div class="field w-full">
                <label for="password">Пароль</label>
                <Password id="password" class="w-full" v-model="userData.password" :loading="loading" fluid></Password>
            </div>

            <div class="field w-full">
                <label for="password_confirmation">Повторите пароль</label>
                <Password id="password_confirmation" class="w-full" v-model="userData.password_confirmation" :loading="loading" fluid></Password>
            </div>

        </div>

        <template #footer>
            <Button label="Отменить" text severity="danger" @click="cancelAddingUser" :loading="loading" autofocus/>
            <Button label="Сохранить" v-if="method === 'create'" outlined severity="success" :loading="loading" @click="addUserHandle" autofocus/>
            <Button label="Сохранить" v-else-if="method === 'update'" outlined severity="success" :loading="loading" @click="updateUserHandle" autofocus/>
        </template>

    </Dialog>
    <Card class="p-card shadow-2 p-2 flex flex-column gap-2">

        <template #header>
            <div class="text-3xl m-2">Пользователи</div>
        </template>

        <template #content>
            <DataTable :value="users" :loading="loading">
                <template #empty>Нет данных для отображения</template>
                <template #header>
                    <Toolbar>
                        <template #start>
                            <Button text outlined icon="pi pi-plus" severity="success" @click="addUser"></Button>
                        </template>
                    </Toolbar>
                </template>
                <Column field="id" header="ID" />
                <Column field="name" header="Имя" />
                <Column field="email" header="Электронная почта" />
                <Column header="Компании" >
                    <template #body="slot">
                        <div class="flex grid gap-3 h-max-10rem m-1">
                            <div class="text-base" v-for="company in slot.data.companies" :key="company.id">{{ company.company_name }}</div>
                        </div>
                    </template>
                </Column>
                <Column>
                    <template #body="slot">
                        <div class="flex flex-row gap-2">
                            <Button severity="warn" icon="pi pi-pencil" outlined text
                                    @click="updateUser(slot.data.id)"></Button>
                            <Button severity="danger" icon="pi pi-trash" outlined text
                                    @click="deleteUser($event, slot.data.id)"></Button>
                        </div>
                    </template>
                </Column>
            </DataTable>
        </template>
    </Card>

</template>

<style scoped>

</style>
