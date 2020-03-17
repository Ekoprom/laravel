<template>
    <v-navigation-drawer
      absolute
      permanent
    >
      <template v-slot:prepend>
        <v-list-item two-line>
          <v-list-item-content>
            <v-list-item-title>{{ propUser }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </template>

      <v-divider></v-divider>

      <v-list dense>
        <v-list-item
          v-for="item in items"
          :key="item.title"
          :to="{ name: item.link }"
        >
          <v-list-item-content>
            <v-list-item-title>{{ item.title }}</v-list-item-title>
          </v-list-item-content>
        </v-list-item>
      </v-list>
    </v-navigation-drawer>
</template>

<script>
    export default {
        data () {
            return {
                items: [
                    { title: 'Заказы', icon: 'mdi-home-city', link: 'orders' },
                    { title: 'Остатки', icon: 'mdi-account', link: 'products' },
                ],
            }
        },

        props: ['prop-user'],

        mounted() {
        },
    }
</script>