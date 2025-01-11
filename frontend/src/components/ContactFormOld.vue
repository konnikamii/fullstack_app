<script setup lang="ts">
import { defineComponent, onMounted, ref } from "vue";
// @ts-ignore
import axios, { AxiosError, AxiosResponse } from "axios";
import {
  ApiResponse,
  ContactsGet,
  Form,
  FormErrors,
  ValidationError,
} from "../utils/types";
import { message } from "ant-design-vue";
import { BACKEND_URL, maxMessageLength } from "../utils/defaults";
import { obfuscateEmail, formatTimestamp } from "../utils/helperFunctions";

const [_, contextHolder] = message.useMessage();

const contacts = ref<ContactsGet["data"]>([]);
const showContacts = ref(false);

const fetchContacts = async () => {
  try {
    const response: AxiosResponse<ContactsGet> = await axios.get(
      `${BACKEND_URL}/api/contacts`
    );
    contacts.value = response.data.data;
  } catch (error) {
    console.error("Error fetching contacts:", error);
  }
};
onMounted(() => {
  const formEl = document.getElementById("contact-form");
  if (formEl) {
    setTimeout(() => {
      formEl.classList.add("show");
    }, 100);
  }
  fetchContacts();
});
</script>

<template>
  <context-holder />
  <div
    class="flex flex-col items-center justify-center gap-10 py-[90px] px-2 w-full h-fit min-h-screen bg-gray-100 dark:bg-gray-800 transition-colors duration-300 overflow-y-auto relative">
    <div class="absolute w-full h-full overflow-hidden pointer-events-none">
      <div class="w-full h-full relative overflow-hidden pointer-events-none">
        <div
          class="scaling-up-side absolute top-0 left-0 translate-x-[-75%] h-full bg-[#c83bf3] rounded-full filter blur-[30px] opacity-60 w-[7px] mix-blend-darken dark:opacity-20 dark:w-[5px] dark:mix-blend-lighten">
        </div>
        <div
          class="scaling-up-side absolute top-0 right-0 translate-x-[75%] h-full bg-[#c83bf3] rounded-full filter blur-[30px] opacity-60 w-[7px] mix-blend-darken dark:opacity-20 dark:w-[5px] dark:mix-blend-lighten">
        </div>
      </div>
    </div>
    <div id="contact-form"
      class="flex flex-col sm:w-[430px] w-auto px-10 py-4 rounded-3xl border shadow-lg transition-all duration-300 border-gray-400 bg-gray-200/40 shadow-gray-200 hover:shadow-gray-300 dark:border-gray-600 dark:bg-white/65 dark:shadow-gray-500/40 backdrop-blur-sm relative overflow-hidden">
      <div
        class="grow-left absolute top-0 left-0 translate-x-[-45%] -translate-y-[95%] w-[200%] aspect-square bg-[#63ab8e] rounded-full mix-blend-multiply filter blur-3xl opacity-40 dark:opacity-60 pointer-events-none">
      </div>
      <div
        class="scaling-up absolute bottom-0 left-0 translate-y-[90%] w-[400%] aspect-square bg-[#2fff39] rounded-full mix-blend-multiply filter blur-3xl opacity-30 dark:opacity-50 pointer-events-none">
      </div>
      <h2 class="text-2xl font-bold mb-6 text-center text-black mt-4">
        Contact Us
      </h2>
      <form @submit.prevent="submitForm" class="space-y-4 mb-3">
        <div>
          <label for="name" class="block text-lg font-semibold text-gray-800 mb-1">Name:</label>
          <a-input v-model:value="form.name" :status="errors.name ? 'error' : ''" @input="() => {
              errors.name = null;
            }
            " />
          <transition name="slide-fade">
            <div v-if="errors.name" class="text-sm text-red-500">
              {{ errors.name }}
            </div>
          </transition>
        </div>
        <div>
          <label for="email" class="block text-lg font-semibold text-gray-800 mb-1">Email:</label>
          <a-input v-model:value="form.email" :status="errors.email ? 'error' : ''" @input="() => {
              errors.email = null;
            }
            " />
          <transition name="slide-fade">
            <div v-if="errors.email" class="text-sm text-red-500">
              {{ errors.email }}
            </div>
          </transition>
        </div>
        <div>
          <label for="subject" class="block text-lg font-semibold text-gray-800 mb-1">Subject:</label>
          <a-input v-model:value="form.subject" :status="errors.subject ? 'error' : ''" @input="() => {
              errors.subject = null;
            }
            " />
          <transition name="slide-fade">
            <div v-if="errors.subject" class="text-sm text-red-500">
              {{ errors.subject }}
            </div>
          </transition>
        </div>
        <div>
          <label for="message" class="block text-lg font-semibold text-gray-800 mb-1">Message:</label>
          <a-textarea v-model:value="form.message" :maxlength="maxMessageLength" :status="errors.message ? 'error' : ''"
            allow-clear class="min-h-32 max-h-[600px]" @input="() => {
                errors.message = null;
              }
              " />
          <div class="w-full min-h-[20px] mb-2 relative">
            <transition name="slide-fade">
              <div v-if="errors.message" class="text-sm text-red-500">
                {{ errors.message }}
              </div>
            </transition>
            <p class="absolute top-0 right-0 translate-y-[2px] text-sm text-gray-500 text-end">
              {{ form.message.length }}/{{ maxMessageLength }}
            </p>
          </div>
        </div>
        <a-button type="primary" html-type="submit" block :loading="isLoading">Send</a-button>
      </form>
    </div>

    <a-button type="default" @click="showContacts = !showContacts">
      {{ showContacts ? "Hide Contacts" : "Show Contacts" }}
    </a-button>
    <div v-if="showContacts" class="contacts-list lg:w-[600px]">
      <h2 class="text-2xl font-bold mb-4 text-black dark:text-white">
        Contacts
      </h2>
      <div>
        <div v-for="contact in contacts" :key="contact.id" class="mb-2">
          <div class="p-4 text-black bg-white dark:text-white dark:bg-gray-700 rounded shadow">
            <p><strong>Name:</strong> {{ contact.name }}</p>
            <p><strong>Email:</strong> {{ obfuscateEmail(contact.email) }}</p>
            <p><strong>Subject:</strong> {{ contact.subject }}</p>
            <p><strong>Message:</strong> {{ contact.message }}</p>
            <p>
              <strong>Created At:</strong>
              {{ formatTimestamp(contact.created_at) }}
            </p>
            <p>
              <strong>Updated At:</strong>
              {{ formatTimestamp(contact.updated_at) }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script lang="ts">
export default defineComponent({
  data() {
    return {
      form: { name: "", email: "", subject: "", message: "" } as Form,
      errors: {
        name: null,
        email: null,
        subject: null,
        message: null,
      } as FormErrors,
      isLoading: false,
      csrfToken: "",
    };
  },
  created() {
    this.fetchCsrfToken();
  },
  methods: {
    fetchCsrfToken() {
      axios
        .get(`${BACKEND_URL}/api/csrf-token`)
        .then((response: AxiosResponse<{ csrf_token: string }>) => {
          this.csrfToken = response.data.csrf_token;
        })
        .catch((error) => {
          console.error("Error fetching CSRF token:", error);
        });
    },
    submitForm() {
      // Custom Validation
      if (!this.form.name) {
        this.errors.name = "Name cannot be empty!";
      }
      if (!this.form.email) {
        this.errors.email = "Email is required!";
      } else if (!/\S+@\S+\.\S+/.test(this.form.email)) {
        this.errors.email = "Email is invalid!";
      }
      if (!this.form.subject) {
        this.errors.subject = "Subject is required!";
      }
      if (!this.form.message) {
        this.errors.message = "Message is required!";
      } else if (this.form.message.length > maxMessageLength) {
        this.errors.message = "Message too long!";
      }
      if (
        this.errors.name ||
        this.errors.email ||
        this.errors.subject ||
        this.errors.message
      ) {
        return;
      }

      this.isLoading = true;
      const formData = new FormData();
      formData.append("name", this.form.name);
      formData.append("email", this.form.email);
      formData.append("subject", this.form.subject);
      formData.append("message", this.form.message);

      axios
        .post<ApiResponse>(`${BACKEND_URL}/api/contacts`, formData, {
          headers: {
            "X-CSRF-TOKEN": this.csrfToken,
          },
        })
        .then((response: AxiosResponse<ApiResponse>) => {
          console.log(response);
          if (response) {
            message.success("Success! Your message has been sent.", 3);
            this.clearForm();
          }
        })
        .catch((error: AxiosError<ApiResponse>) => {
          console.log(error);
          if (error.response && error.response.data.errors) {
            this.setErrors(error.response.data.errors);
            message.error(
              "Validation failed: " +
              Object.values(error.response.data.errors).join(", "),
              3
            );
          } else {
            message.error("An error occurred. Please try again.", 3);
          }
        });
      setTimeout(() => (this.isLoading = false), 1500);
    },
    setErrors(errors: ValidationError) {
      for (const key in errors) {
        if (errors.hasOwnProperty(key)) {
          this.errors[key as keyof FormErrors] = errors[key].join(", ");
        }
      }
    },
    clearForm() {
      this.form.name = "";
      this.form.email = "";
      this.form.subject = "";
      this.form.message = "";
    },
    clearError(field: keyof Form) {
      console.log(field);
      this.errors[field] = null;
    },
  },
});
</script>

<style scoped>
.slide-fade-enter-active {
  transition: all 0.3s ease;
}

.slide-fade-leave-active {
  transition: all 0.2s ease;
}

.slide-fade-enter-from {
  max-height: 0;
  opacity: 0;
  overflow: hidden;
}

.slide-fade-enter-to {
  max-height: 30px;
  opacity: 1;
}

.slide-fade-leave-from {
  max-height: 30px;
  opacity: 1;
}

.slide-fade-leave-to {
  max-height: 0;
  opacity: 0;
  overflow: hidden;
}
</style>
