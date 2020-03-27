<template>
    <v-row justify="center" msg='fff'>
        <v-dialog ref="errorModal" v-model="$store.state.error.active" persistent max-width="290">
            <v-card>
                <v-card-title class="headline">Ошибка</v-card-title>
                <v-card-text>{{ $store.state.error.message }}</v-card-text>
                <v-card-actions>
                    <v-spacer></v-spacer>
                    <v-btn color="green darken-1" text @click="$store.state.error.active = false">Ok</v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </v-row>
</template>