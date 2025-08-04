<template>
  <EcommerceLayout title="Contact Us">
    <div class="min-h-screen bg-background">
      <!-- Hero Section -->
      <div class="bg-card border-b-2 border-border">
        <div class="container mx-auto px-4 py-16">
          <div class="text-center">
            <h1 class="text-4xl font-bold text-foreground mb-4">Contact Us</h1>
            <p class="text-xl text-muted-foreground max-w-2xl mx-auto">
              We'd love to hear from you. Get in touch with our team for any questions or support.
            </p>
          </div>
        </div>
      </div>

      <div class="container mx-auto px-4 py-12">
        <div class="max-w-6xl mx-auto">
          <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <!-- Contact Form -->
            <div>
              <h2 class="text-3xl font-bold text-foreground mb-6">Send us a Message</h2>
              <form @submit.prevent="submitForm" class="space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                  <div>
                    <label for="first_name" class="block text-sm font-medium text-card-foreground mb-2">
                      First Name *
                    </label>
                    <input
                      id="first_name"
                      v-model="form.first_name"
                      type="text"
                      required
                      class="w-full px-4 py-3 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                      placeholder="Enter your first name"
                    />
                  </div>
                  <div>
                    <label for="last_name" class="block text-sm font-medium text-card-foreground mb-2">
                      Last Name *
                    </label>
                    <input
                      id="last_name"
                      v-model="form.last_name"
                      type="text"
                      required
                      class="w-full px-4 py-3 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                      placeholder="Enter your last name"
                    />
                  </div>
                </div>

                <div>
                  <label for="email" class="block text-sm font-medium text-card-foreground mb-2">
                    Email Address *
                  </label>
                  <input
                    id="email"
                    v-model="form.email"
                    type="email"
                    required
                    class="w-full px-4 py-3 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter your email address"
                  />
                </div>

                <div>
                  <label for="phone" class="block text-sm font-medium text-card-foreground mb-2">
                    Phone Number
                  </label>
                  <input
                    id="phone"
                    v-model="form.phone"
                    type="tel"
                    class="w-full px-4 py-3 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                    placeholder="Enter your phone number"
                  />
                </div>

                <div>
                  <label for="subject" class="block text-sm font-medium text-card-foreground mb-2">
                    Subject *
                  </label>
                  <select
                    id="subject"
                    v-model="form.subject"
                    required
                    class="w-full px-4 py-3 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring"
                  >
                    <option value="">Select a subject</option>
                    <option value="general">General Inquiry</option>
                    <option value="order">Order Support</option>
                    <option value="product">Product Question</option>
                    <option value="shipping">Shipping & Delivery</option>
                    <option value="return">Returns & Refunds</option>
                    <option value="technical">Technical Support</option>
                    <option value="partnership">Partnership</option>
                    <option value="other">Other</option>
                  </select>
                </div>

                <div>
                  <label for="message" class="block text-sm font-medium text-card-foreground mb-2">
                    Message *
                  </label>
                  <textarea
                    id="message"
                    v-model="form.message"
                    required
                    rows="6"
                    class="w-full px-4 py-3 border-2 border-border rounded-[5px] bg-background text-foreground focus:outline-none focus:ring-2 focus:ring-ring resize-vertical"
                    placeholder="Tell us how we can help you..."
                  ></textarea>
                </div>

                <button
                  type="submit"
                  :disabled="isSubmitting"
                  class="w-full bg-primary text-primary-foreground font-medium py-3 px-6 rounded-[5px] border-2 border-border shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                >
                  {{ isSubmitting ? 'Sending...' : 'Send Message' }}
                </button>
              </form>
            </div>

            <!-- Contact Information -->
            <div>
              <h2 class="text-3xl font-bold text-foreground mb-6">Get in Touch</h2>
              
              <!-- Contact Cards -->
              <div class="space-y-6">
                <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                  <div class="flex items-start space-x-4">
                    <div class="text-3xl">📧</div>
                    <div>
                      <h3 class="text-lg font-semibold text-card-foreground mb-2">Email Support</h3>
                      <p class="text-muted-foreground mb-2">
                        For general inquiries and support
                      </p>
                      <a href="mailto:support@eshop.com" class="text-primary hover:underline font-medium">
                        support@eshop.com
                      </a>
                    </div>
                  </div>
                </div>

                <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                  <div class="flex items-start space-x-4">
                    <div class="text-3xl">📞</div>
                    <div>
                      <h3 class="text-lg font-semibold text-card-foreground mb-2">Phone Support</h3>
                      <p class="text-muted-foreground mb-2">
                        Monday - Friday, 9AM - 6PM WIB
                      </p>
                      <a href="tel:+6212345678901" class="text-primary hover:underline font-medium">
                        +62 123 456 7890
                      </a>
                    </div>
                  </div>
                </div>

                <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                  <div class="flex items-start space-x-4">
                    <div class="text-3xl">💬</div>
                    <div>
                      <h3 class="text-lg font-semibold text-card-foreground mb-2">Live Chat</h3>
                      <p class="text-muted-foreground mb-2">
                        Available 24/7 for immediate assistance
                      </p>
                      <button class="text-primary hover:underline font-medium">
                        Start Live Chat
                      </button>
                    </div>
                  </div>
                </div>

                <div class="bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                  <div class="flex items-start space-x-4">
                    <div class="text-3xl">📍</div>
                    <div>
                      <h3 class="text-lg font-semibold text-card-foreground mb-2">Office Address</h3>
                      <p class="text-muted-foreground">
                        Jl. Sudirman No. 123<br>
                        Jakarta Pusat 10110<br>
                        Indonesia
                      </p>
                    </div>
                  </div>
                </div>
              </div>

              <!-- Business Hours -->
              <div class="mt-8 bg-card border-2 border-border rounded-[5px] shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] p-6">
                <h3 class="text-lg font-semibold text-card-foreground mb-4">Business Hours</h3>
                <div class="space-y-2 text-sm">
                  <div class="flex justify-between">
                    <span class="text-muted-foreground">Monday - Friday</span>
                    <span class="text-card-foreground font-medium">9:00 AM - 6:00 PM WIB</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-muted-foreground">Saturday</span>
                    <span class="text-card-foreground font-medium">10:00 AM - 4:00 PM WIB</span>
                  </div>
                  <div class="flex justify-between">
                    <span class="text-muted-foreground">Sunday</span>
                    <span class="text-card-foreground font-medium">Closed</span>
                  </div>
                </div>
              </div>

              <!-- FAQ Link -->
              <div class="mt-6 text-center">
                <p class="text-muted-foreground mb-4">
                  Looking for quick answers?
                </p>
                <Link href="/faq">
                  <button class="bg-background text-foreground font-medium py-2 px-6 rounded-[5px] border-2 border-border shadow-[4px_4px_0px_0px_rgba(0,0,0,1)] hover:shadow-[6px_6px_0px_0px_rgba(0,0,0,1)] hover:translate-x-[-2px] hover:translate-y-[-2px] transition-all duration-200">
                    Check Our FAQ
                  </button>
                </Link>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </EcommerceLayout>
</template>

<script setup lang="ts">
import { ref, reactive } from 'vue'
import { Link } from '@inertiajs/vue3'
import EcommerceLayout from '@/layouts/EcommerceLayout.vue'

const isSubmitting = ref(false)

const form = reactive({
  first_name: '',
  last_name: '',
  email: '',
  phone: '',
  subject: '',
  message: ''
})

const submitForm = async () => {
  isSubmitting.value = true
  
  try {
    // Simulate form submission
    await new Promise(resolve => setTimeout(resolve, 2000))
    
    // Reset form
    Object.keys(form).forEach(key => {
      form[key as keyof typeof form] = ''
    })
    
    alert('Thank you for your message! We will get back to you soon.')
  } catch (error) {
    alert('There was an error sending your message. Please try again.')
  } finally {
    isSubmitting.value = false
  }
}
</script>
