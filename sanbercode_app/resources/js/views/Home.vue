<template>
    <div>
        <v-container class="ma-0 pa-0" grid-list-sm>
            <div class="text-right">
                    <v-btn small text to="/campaigns" class="blue--text">
                        All Campaigns <v-icon>mdi-chevron-right</v-icon>
                    </v-btn>
            </div>
            <v-layout wrap>
                <v-flex v-for="(campaign) in campaigns" :key="`category-`+campaign.id" xs6>
                    <campaign-item :campaign="campaign"></campaign-item>
                    
                </v-flex>
            </v-layout>
        </v-container>
        <v-container class="ma-0 pa-0" grid-list-sm>
            <div class="text-right">
                    <v-btn small text to="/blogs" class="blue--text">
                        All Campaigns <v-icon>mdi-chevron-right</v-icon>
                    </v-btn>
            </div>
            
            <v-layout wrap>
                <v-carousel hide-delimiters height="250px">
                    <v-carousel-item v-for="(blog) in blogs" :key="`category-`+blog.id">
                        <v-img :src="blog.image" class="fill-height">
                            <v-container fill-height fluid pa-0 ma-0>
                                <v-layout fill-height align-end>
                                    <v-flex xs12 mx-2>
                                        <span class="headline white--text" v-text="blog.title"></span>
                                    </v-flex>
                                </v-layout>
                            </v-container>
                        </v-img>

                    </v-carousel-item>
                </v-carousel>
            </v-layout>
        </v-container>
    </div>
</template>

<script>
import CampaignItem from '../components/CampaignItem.vue'
    export default {
    components: { CampaignItem },
        data:() => ({
            campaigns:[],
            blogs:[]
        }),
        created(){
            axios.get('api/campaign/random/2')
                .then( (response)=>{
                    let {data} = response.data
                    this.campaigns = data.campaigns

                })
                .catch((error)=>{
                    let{response} = error
                    console.log(responses)
                })
             axios.get('api/blog/random/2')
                .then( (response)=>{
                    let {data} = response.data
                    this.blogs = data.blogs

                })
                .catch((error)=>{
                    let{response} = error
                    console.log(responses)
                })
        }

    }
</script>
