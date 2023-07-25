<template>
   <div>   
     <div>
       <router-view></router-view>
     </div>     
   </div>  
</template> 

<script>
export default {
 middleware:["auth", "role:1"],

  metaInfo() {
    return { title: this.$t("Socio accionista") };
  },

};
</script>

