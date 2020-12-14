<template>
    <div>
        <v-card v-if="campaign.id">
            <v-img
                :src="baseurl + campaign.image"
                class="black--text"
                height="300px"
            >
                <v-card-title
                    class="fill-height align-end"
                    v-text="campaign.title"
                ></v-card-title>
            </v-img>

            <v-card-text>
                <v-simple-table dense>
                    <tbody>
                        <tr>
                            <td><v-icon>mdi-home-city</v-icon>Address</td>
                            <td>{{ campaign.address }} </td>
                        </tr>
                        <tr>
                            <td><v-icon>mdi-cash</v-icon>Required</td>
                            <td class="orange--text">Rp {{ campaign.required.toLocaleString('id-ID')}} </td>
                        </tr>
                        <tr>
                            <td><v-icon>mdi-hand-heart</v-icon>Collected</td>
                            <td class="blue--text">Rp {{ campaign.collected.toLocaleString('id-ID')}} </td>
                        </tr>
                    </tbody>
                </v-simple-table>
                Description : <br>
                {{ campaign.description }}

            </v-card-text>
            <v-card-actions>
                <v-btn block color="primary" @click="donate" :disabled="campaign.collected >= campaign.required">
                    <v-icon>mdi-cash-usd</v-icon> &nbsp;
                    DONATE
                </v-btn>
            </v-card-actions>
        </v-card>
    </div>
</template>

<script>
import { mapActions, mapMutations } from 'vuex'
    export default {
        data: () => ({            
            campaign: {},  // Hanya satu Object, bukan array of objects
            baseurl : 'http://localhost:8000/',
        }),
        created(){
            this.go()
        },
        methods: {
            
            ...mapMutations({
                addTransaction : 'transaction/insert'
            }),
    
            ...mapActions({
                setAlert : 'alert/set'
            }),
    
            donate () {
                this.addTransaction()
                this.setAlert({
                    status  : true,
                    color   : 'success',
                    text    : 'Transaction successfully added'
                })
            },

            go(){
            let { id } = this.$route.params
            let url = '/api/campaign/' + id
            axios.get(url)
                .then((response) => {
                    
                    let { data } = response.data                    
                    this.campaign = data.campaign
                    // console.log(this.campaign)

                })

                .catch((error) => {
                    let { response } = error
                    console.log(responses + " - Error")
                })

            },


            // ...mapMutations({
                //     'donate' : 'transaction/insert'  // "Left" New Instance, "Right" from modules &then $store
            // }),   

            // donate() {
            //     this.$store.commit('insert')
            // }
        }
    }
</script>