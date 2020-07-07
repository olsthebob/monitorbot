<template>
  <div>
    <form method="POST" :action="this.route" @submit.prevent="submitForm">
      <div class="form-group mb-2">
        <label>Test Type</label>
        <select class="form-control" v-model="fields.test_type" title="Select Test Type">
          <option selected disabled>Please Select Test Type</option>
          <option>Check Google Analytics</option>
          <option>Check Tag Manager</option>
          <option>Check Meta Description</option>
          <option>Check Element Loading</option>
        </select>
      </div>

      <div class="form-group mb-3" v-if="fields.test_type">
        <label class="mr-2">Page URL</label>
        <small class="text-muted text-right">Leave blank for index</small>
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text">{{ this.site.site_url }}/</span>
          </div>
          <input type="text" class="form-control" v-model="fields.test_url" />
        </div>
      </div>

      <div class="form-group pb-3" v-if="fields.test_type == 'Check Element Loading'">
        <label>Element</label>
        <div class="input-group">
          <select class="form-control col-3" v-model="fields.element_type">
            <option selected disabled>Please Select</option>
            <option value="#">ID</option>
            <option value=".">Class</option>
          </select>
          <input
            type="text"
            class="form-control"
            placeholder="element name"
            v-model="fields.element"
          />
        </div>
      </div>

      <button type="submit" class="btn btn-primary mt-4">Add Test</button>
    </form>
  </div>
</template>

<script>
export default {
  name: "new-test-form",
  props: ["route", "site"],
  data() {
    return {
      fields: {
        site_id: this.site.id,
        site_root_url: this.site.site_url + "/"
      },
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

