<script setup lang="ts">
import { ref, reactive, onMounted } from "vue";
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

const [_, contextHolder] = message.useMessage(); // For Antd message notifications

// #region State variables
const contacts = ref<ContactsGet["data"]>([]);
const showContacts = ref(false);
const csrfToken = ref("");
const isLoading = ref(false);

const form = reactive<Form>({
  name: "",
  email: "",
  subject: "",
  message: "",
});

const errors = reactive<FormErrors>({
  name: null,
  email: null,
  subject: null,
  message: null,
});
// #endregion

// #region Methods
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

const fetchCsrfToken = async () => {
  try {
    const response: AxiosResponse<{ csrf_token: string }> = await axios.get(
      `${BACKEND_URL}/api/csrf-token`
    );
    csrfToken.value = response.data.csrf_token;
  } catch (error) {
    console.error("Error fetching CSRF token:", error);
  }
};

const clearForm = () => {
  form.name = "";
  form.email = "";
  form.subject = "";
  form.message = "";
};

const setErrors = (validationErrors: ValidationError) => {
  for (const key in validationErrors) {
    if (validationErrors.hasOwnProperty(key)) {
      errors[key as keyof FormErrors] = validationErrors[key].join(", ");
    }
  }
};

const validateForm = (): boolean => {
  let valid = true;

  if (!form.name) {
    errors.name = "Name cannot be empty!";
    valid = false;
  }
  if (!form.email) {
    errors.email = "Email is required!";
    valid = false;
  } else if (!/\S+@\S+\.\S+/.test(form.email)) {
    errors.email = "Email is invalid!";
    valid = false;
  }
  if (!form.subject) {
    errors.subject = "Subject is required!";
    valid = false;
  }
  if (!form.message) {
    errors.message = "Message is required!";
    valid = false;
  } else if (form.message.length > maxMessageLength) {
    errors.message = "Message too long!";
    valid = false;
  }

  return valid;
};

const submitForm = async () => {
  if (!validateForm()) {
    return;
  }

  isLoading.value = true;

  const formData = new FormData();
  formData.append("name", form.name);
  formData.append("email", form.email);
  formData.append("subject", form.subject);
  formData.append("message", form.message);

  try {
    await axios.post<ApiResponse>(`${BACKEND_URL}/api/contacts`, formData, {
      headers: {
        "X-CSRF-TOKEN": csrfToken.value,
      },
    });
    message.success("Success! Your message has been sent.", 3);
    clearForm();
  } catch (error) {
    const err = error as AxiosError<ApiResponse>;
    if (err.response?.data.errors) {
      setErrors(err.response.data.errors);
      message.error(
        "Validation failed: " +
        Object.values(err.response.data.errors).join(", "),
        3
      );
    } else {
      message.error("An error occurred. Please try again.", 3);
    }
  } finally {
    isLoading.value = false;
  }
};
// #endregion

// Lifecycle hooks
onMounted(() => {
  const formEl = document.getElementById("contact-form");
  if (formEl) {
    setTimeout(() => {
      formEl.classList.add("show");
    }, 100);
  }
  fetchContacts();
  fetchCsrfToken();
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
              <div v-if="errors.message" class="text-sm text-red-500 sm:w-10/12 w-8/12">
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
