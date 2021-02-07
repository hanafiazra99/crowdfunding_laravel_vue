<template>
    <div>
        <v-container>
            <v-subheader>
                All Campaigns
            </v-subheader>
            <v-layout wrap>
                <v-flex v-for="(campaign) in campaigns" :key="`campaign-`+campaign.id" xs6>
                    <campaign-item :campaign="campaign"></campaign-item>
                </v-flex>
            </v-layout>
             <v-pagination
                  v-model="page"
                  @input="go"
                  :length="lengthPage"
                  total-visible="6"
                ></v-pagination>
        </v-container>
    </div>
</template>
<script>
import CampaignItem from '../components/CampaignItem.vue'
    export default {
  components: { CampaignItem },
        data: ()=>({
            campaigns:[],
            page:0,
            lengthPage:0
        }),
        created(){
            this.go()
        },
        methods:{
            go(){
                let url = 'api/campaign?page'+this.page
                axios.get(url)
                    .then((response) => {
                        let {data} = response.data
                        this.campaigns = data.campaigns.data
                        this.lengthPage = data.campaigns.last_page
                    })
                    .catch((error)=>{
                        let {response} = error
                        console.log(reponses)
                    })
            }
        }
    }
</script>
