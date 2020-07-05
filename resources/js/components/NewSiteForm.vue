<template>
  <div>
    <form method="POST" :action="this.route" @submit.prevent="submitForm">
      <div class="form-group pb-2">
        <label>Website Name</label>
        <input
          type="text"
          class="form-control"
          name="name"
          placeholder="ACME Inc Website"
          v-model="fields.name"
        />
      </div>

      <div class="form-group pb-3">
        <label>Website URL</label>
        <div class="input-group">
          <input
            type="text"
            class="form-control"
            name="site_url"
            placeholder="https://acmeinc.co"
            v-model="fields.site_url"
          />
        </div>
      </div>

      <button type="submit" class="btn btn-primary">Add Site</button>
    </form>
  </div>
</template>

<script>
export default {
  name: "new-site-form",
  props: ["route"],
  data() {
    return {
      fields: {},
      errors: {}
    };
  },
  methods: {
    submitForm: function(e) {
      axios
        .post(this.route, this.fields)
        .then(
          response => (
            (this.fields = {}), (window.location = response.data.redirect)
          )
        );
    }
  }
};
</script>

