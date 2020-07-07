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
              <p class="text-muted mb-0">{{ site.site_url }}</p>
            </div>
            <div class="col-4">
              <div class="card-icon-actions text-right">
                <span class="badge badge-dot" v-if="site.tests">
                  {{site.tests.length}} Tests Running
                  <i class="bg-primary ml-1"></i>
                </span>

                <div v-if="activeAlerts(site.alerts).length > 0">
                  <span class="badge badge-dot" v-for="active in activeAlerts(site.alerts)">
                    {{ active.message }}
                    <i class="bg-red ml-1"></i>
                  </span>
                </div>
                <div v-else>
                  <span class="badge badge-dot">
                    Website Available
                    <i class="bg-green ml-1"></i>
                  </span>
                </div>
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

  methods: {
    activeAlerts: function(item) {
      return item.filter(function(item) {
        return item.resolved == 0;
      });
    }
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
