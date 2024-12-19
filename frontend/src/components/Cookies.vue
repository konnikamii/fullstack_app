<script setup lang="ts">
import { defineComponent,onMounted } from "vue";   
import { message } from "ant-design-vue";
const [messageApi, contextHolder] = message.useMessage();

onMounted(() => {
  const banner = document.getElementById('cookie-consent-banner');
  const settingsPopup = document.getElementById('cookie-settings-popup');
  const popupClose = document.querySelectorAll('#closing-popup-element');
  const btnSettings = document.getElementById('btn-settings');
  const btnSaveSettings = document.getElementById('btn-save-settings');
  const btnAcceptAll = document.getElementById('btn-accept-all');
  const btnRejectAll = document.getElementById('btn-reject-all');
  const btnReopenCookies = document.getElementById('nav-footer-cookies');
  
  const analyticsInput = document.getElementById("consent-analytics") as HTMLInputElement;
  const marketingInput = document.getElementById("consent-marketing") as HTMLInputElement;

  if (banner) {
    try {
      const storedConsentData = localStorage.getItem('ucData');
      const expiration = localStorage.getItem('ucDataExpire');
      if (storedConsentData) {
        const parsedConsentData = JSON.parse(storedConsentData);
        analyticsInput.checked = parsedConsentData.analytics_storage === 'granted';
        marketingInput.checked = parsedConsentData.ad_storage === 'granted';
        const isAnyDenied = Object.values(parsedConsentData).some(value => value === 'denied');
        if (isAnyDenied) {
          if (expiration) {
            const currentTime = new Date().getTime();
            const oneDayInMilliseconds = 24 * 60 * 60 * 1000;
            if (currentTime - parseInt(expiration) > oneDayInMilliseconds) {
              setTimeout(() => {
                banner.classList.add('show');
              }, 1000);
            }
          } else {
            setTimeout(() => {
              banner.classList.add('show');
            }, 1000);
          }
        } else {
          banner.style.display = 'none';
        }
      } else {
        setTimeout(() => {
          banner.classList.add('show');
        }, 1000);
      }
    } catch (error) {
      console.error('Failed to parse consent data:', error);
      setTimeout(() => {
        banner.style.display = 'fixed';
        banner.style.opacity = '1';
      }, 1000);
    }

    settingsPopup?.addEventListener('click', (event) => {
      event.stopPropagation();
    });

    const hideSettingsPopup = () => {
      if (settingsPopup) settingsPopup.style.display = 'none';
    };
    const showSettingsPopup = () => {
      if (settingsPopup) settingsPopup.style.display = 'flex';
    };
    popupClose.forEach((element) => {
      element.addEventListener('click', hideSettingsPopup);
    });
    btnSettings?.addEventListener('click', showSettingsPopup);
    btnReopenCookies?.addEventListener('click', showSettingsPopup);

    btnSaveSettings?.addEventListener('click', () => {
      const newConsentData = {
        ad_storage: marketingInput.checked ? 'granted' : 'denied',
        analytics_storage: analyticsInput.checked ? 'granted' : 'denied',
        ad_user_data: marketingInput.checked ? 'granted' : 'denied',
        ad_personalization: marketingInput.checked ? 'granted' : 'denied',
        personalization_storage: analyticsInput.checked ? 'granted' : 'denied',
        functionality_storage: analyticsInput.checked ? 'granted' : 'denied',
        security_storage: analyticsInput.checked ? 'granted' : 'denied',
      };
      localStorage.setItem('ucData', JSON.stringify(newConsentData));
      if (!analyticsInput.checked || !marketingInput.checked) {
        localStorage.setItem('ucDataExpire', new Date().getTime().toString());
      }
      hideSettingsPopup();
      banner.classList.remove('show');
      messageApi.success('Preferences Updated!',2)
      setTimeout(() => { banner.style.display = 'none'; }, 500);
    });

    btnAcceptAll?.addEventListener('click', () => {
      localStorage.setItem('ucData', JSON.stringify({ ad_storage: 'granted', analytics_storage: 'granted' }));
      banner.classList.remove('show');
      messageApi.success('Preferences Updated!',2)
      setTimeout(() => { banner.style.display = 'none'; }, 500);
    });

    btnRejectAll?.addEventListener('click', () => {
      localStorage.setItem('ucData', JSON.stringify({ ad_storage: 'denied', analytics_storage: 'denied' }));
      localStorage.setItem('ucDataExpire', new Date().getTime().toString());
      banner.classList.remove('show');
      messageApi.success('Preferences Updated!',2)
      setTimeout(() => { banner.style.display = 'none'; }, 500);
    });
  }
});
</script>

<template>
  <context-holder />  
  <div id="cookie-consent-banner" class="fixed bottom-0 left-0 w-full transition-all duration-300 p-2">
    <div class="rounded-lg text-black bg-gray-300/70 dark:text-white dark:bg-gray-800/70 border-t border-gray-200 dark:border-gray-600 px-10 py-6 backdrop-blur select-text transition-all duration-300 ">
        <h3 class="text-xl font-semibold mb-4">Cookie Notice</h3>
        <div class="flex justify-between md:flex-row flex-col gap-4"> 
            <p class="text-sm ">We use cookies to provide you with the best possible experience! They allow us to analyze user behavior in order to constantly improve the website for you. By clicking 'Accept All', you consent to our use of cookies. <a href="/privacy" class="underline underline-offset-2" draggable="false">Read More</a>
            </p>
            <div class="flex sm:space-x-2 sm:space-y-0 space-y-2 sm:flex-row flex-col justify-end flex-grow text-nowrap h-fit select-none">
                <button id="btn-reject-all" class="cookie-consent-button btn-grayscale
                text-nowrap text-center px-3 py-1 border shadow-sm rounded-lg bg-transparent text-black dark:text-white border-gray-500 shadow-transparent transition-all duration-300 hover:bg-gray-200 dark:hover:bg-gray-700 hover:border-gray-500 hover:shadow-gray-500 active:border-gray-700 active:shadow-gray-600 disabled:opacity-40 disabled:shadow-transparent disabled:active:border-gray-500 disabled:cursor-not-allowed relative overflow-hidden">Reject All</button>
                <button id="btn-settings" class="cookie-consent-button btn-outline 
                text-nowrap text-center px-3 py-1 border shadow-sm rounded-lg text-black hover:text-black bg-gray-100 border-gray-400 shadow-transparent transition-all duration-300 hover:bg-gray-300 hover:border-gray-400 hover:shadow-gray-400 active:border-black active:shadow-gray-500 disabled:bg-gray-200 disabled:text-gray-400 disabled:active:border-gray-400 disabled:hover:border-gray-400 disabled:shadow-transparent disabled:cursor-not-allowed relative overflow-hidden">Settings</button>
                <button id="btn-accept-all" class="cookie-consent-button btn-success 
                font-[500] text-nowrap text-center px-3 py-1 border shadow-sm rounded-lg 
                text-white hover:text-white bg-black dark:bg-[#1677ff] border-gray-700 shadow-transparent
                hover:border-gray-500 hover:shadow-gray-500 active:border-gray-700 active:shadow-gray-600 hover:opacity-75 
                disabled:bg-gray-600 disabled:text-gray-400 disabled:active:border-gray-400 disabled:hover:border-gray-400 disabled:shadow-transparent disabled:cursor-not-allowed
                transition-all duration-300 relative overflow-hidden">Accept All</button>
            </div>
        </div>
    </div>
  </div> 
        
  <div id="cookie-settings-popup" class="cookie-settings-popup fixed inset-0 bg-gray-900 dark:text-white/95 bg-opacity-75 flex flex-col items-center justify-center z-50" style="display: none;">
  <div id="closing-popup-element" class="flex-1 w-full min-h-[90px]"></div>
  <div class="flex w-full justify-stretch h-auto"> 
      <div id="closing-popup-element" class="flex-1"></div>
      <div class="flex-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-lg sm:min-w-[500px] sm:max-w-[500px] min-w-[90%] max-w-[90%] mx-2 z-10">
          <div class="flex justify-between mb-4">
              <h3 class="text-xl font-semibold">Privacy Settings</h3>
              <button id="closing-popup-element" class="text-lg font-semibold text-gray-600 hover:text-gray-800 dark:text-gray-400 dark:hover:text-gray-100 translate-y-[-6px] transition duration-300">&times;</button> 
          </div>
          <p class="text-sm">This tool helps you to select, activate or deactivate certain features on this website such as trackers, tags and analysis tools.</p> 
          <div class="cookie-consent-options space-y-2 mt-4 overflow-auto max-h-[50vh]">
              <label class="flex items-center space-x-2 py-4 px-2 rounded-md border bg-gray-50 hover:bg-gray-50 border-gray-500 dark:bg-gray-700 dark:hover:bg-gray-700 dark:border-gray-600 relative">
                  <div>
                      <h4 class="mb-1 font-medium">Necessary</h4> 
                      <p class="text-sm italics text-gray-500 dark:text-gray-200 pr-20">Essential tags required to provide basic functionalities to the website.</p> 
                  </div>
                  <input id="consent-necessary" type="checkbox" value="Necessary" checked disabled class="form-checkbox absolute top-1/2 right-[15px] -translate-y-1/2"/>
              </label>
              <label id="analytics-label" class="flex items-center space-x-2 py-4 px-2 rounded-md border bg-gray-50 hover:bg-gray-100 border-gray-500 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-500 relative cursor-pointer transition-all duration-300">
                  <div>
                      <h4 class="mb-1 font-medium">Analytics</h4> 
                      <p class="text-sm italics text-gray-500 dark:text-gray-200 pr-20">Analytical cookies used to understand visitor interactions with the website. They help us find areas of improvement to provide you with a better experience.</p> 
                  </div>
                  <input id="consent-analytics" type="checkbox" value="Analytics" class="form-checkbox absolute top-1/2 right-[15px] -translate-y-1/2"/>
              </label> 
              <label id="marketing-label" class="flex items-center space-x-2 py-4 px-2 rounded-md border bg-gray-50 hover:bg-gray-100 border-gray-500 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-500 relative cursor-pointer transition-all duration-300">
                  <div>
                      <h4 class="mb-1 font-medium">Marketing</h4> 
                      <p class="text-sm italics text-gray-500 dark:text-gray-200 pr-20">Marketing cookies provide visitors with relevant advertisements based on their previous browsing activity. They also help us analyze the effectiveness of the ad campaigns.</p> 
                  </div>
                  <input id="consent-marketing" type="checkbox" value="Marketing" class="form-checkbox absolute top-1/2 right-[15px] -translate-y-1/2"/>
              </label> 
          </div>
          <div class="flex justify-end gap-2 mt-4">
              <button id="closing-popup-element" class="text-nowrap text-center px-3 py-1 border shadow-sm rounded-lg text-black hover:text-black bg-white border-gray-300 shadow-gray-200 transition-all duration-300 hover:bg-gray-50 hover:border-gray-400 hover:shadow-gray-400 active:border-black active:shadow-gray-500 disabled:bg-gray-200 disabled:text-gray-400 disabled:active:border-gray-400 disabled:hover:border-gray-400 disabled:shadow-transparent disabled:cursor-not-allowed relative overflow-hidden">Close</button>
              <button id="btn-save-settings" class="text-nowrap text-center px-3 py-1 border shadow-md rounded-lg 
          text-white hover:text-white bg-[#1677ff] border-gray-500 shadow-transparent 
          hover:border-gray-500 hover:shadow-blue-700 hover:opacity-80 
          active:border-gray-200 active:shadow-blue-500 
          disabled:active:border-gray-500 disabled:shadow-transparent disabled:opacity-60 disabled:cursor-not-allowed
          transition-all duration-300 relative overflow-hidden w-[100px]">Save</button>
          </div>
      </div>
      <div id="closing-popup-element" class="flex-1"></div>
  </div>
  <div id="closing-popup-element" class="flex-1 w-full min-h-[30px]"></div>
  </div> 
</template>

<script lang="ts">
export default defineComponent({ 
});

</script>

<style scoped> 
</style>
