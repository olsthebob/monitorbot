<template>
  <div v-if="tests.length">
    <div class="card mb-3" v-for="test in tests">
      <div class="card-header">
        <div class="row align-items-center">
          <div class="col-8">
            <h4 class="heading h5 mb-0">{{ test.type }}</h4>
            <p
              class="text-muted mb-0"
              v-if="test.type === 'Check Element Loading'"
            >{{ test.element }} at {{ test.test_url }}</p>
          </div>
          <div class="col-4">
            <div class="card-icon-actions text-right">
              <span class="badge badge-dot" v-if="test.status == 1">
                Passing
                <i class="bg-green ml-1"></i>
              </span>
              <span class="badge badge-dot" v-else-if="test.status == 0">
                Failing
                <i class="bg-red ml-1"></i>
              </span>
              <span class="badge badge-dot" v-else>
                Pending
                <i class="bg-secondary ml-1"></i>
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="pt-5" v-else>
    <p class="text-muted text-center">There are no tests for this site. Please create one above :)</p>
  </div>
</template>

<script>
export default {
  name: "test-feed",
  props: ["tests"]
};
</script>
