<template>
  <div>
    <div class="form-group">
      <div class="input-group input-group-transparent mb-4">
        <div class="input-group-prepend">
          <span class="input-group-text">
            <i class="fas fa-search"></i>
          </span>
        </div>
        <input
          type="text"
          class="form-control form-control-lg"
          v-model="search"
          placeholder="Search"
        />
      </div>
    </div>

    <hr class="mb-4" />

    <div class="card mb-3" v-for="site in siteSearch">
      <a v-bind:href="'site/' + site.id">
        <div class="card-header">
          <div class="row align-items-center">
            <div class="col-8">
              <h4 class="heading h5 mb-0">{{ site.name }}</h4>
            </div>
            <div class="col-4">
              <div class="card-icon-actions text-right">

                <span class="badge badge-dot" v-if="site.status === 1">
                  Passing
                  <i class="bg-green ml-1"/></i>
                </span>
                <span class="badge badge-dot" v-else-if="site.status === 0">
                  Failing
                  <i class="bg-red ml-1"/></i>
                </span>
                <span class="badge badge-dot" v-else>
                  Pending
                  <i class="bg-secondary ml-1"/></i>
                </span>

              </div>
            </div>
          </div>
        </div>
      </a>
    </div>
  </div>
</template>

<script>
export default {
  name: "site-search",
  props: ["sites"],
  data() {
    return {
      search: ""
    };
  },
  computed: {
    siteSearch() {
      return this.sites.filter(site => {
        return site.name.toLowerCase().includes(this.search.toLowerCase());
      });
    }
  }
};
</script>
