<!-- Footer Component -->
<footer class="footer">
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- About Section -->
            <div>
                <h3 class="footer-title">About Us</h3>
                <p class="text-gray-400 mb-4">Making tax filing simple, fast, and stress-free for individuals and businesses across the country.</p>
                <div class="social-links flex">
                    <a href="#" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                    <a href="#" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="footer-title">Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="#services">Our Services</a></li>
                    <li><a href="#how-it-works">How It Works</a></li>
                    <li><a href="#tax-calculator">Tax Calculator</a></li>
                    <li><a href="#">Pricing</a></li>
                    <li><a href="#">Contact Us</a></li>
                </ul>
            </div>

            <!-- Services -->
            <div>
                <h3 class="footer-title">Our Services</h3>
                <ul class="footer-links">
                    <li><a href="#">TIN Registration</a></li>
                    <li><a href="#">Tax Return Filing</a></li>
                    <li><a href="#">VAT Registration</a></li>
                    <li><a href="#">Tax Consultation</a></li>
                    <li><a href="#">Business Tax Services</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div>
                <h3 class="footer-title">Contact Us</h3>
                <ul class="footer-links">
                    <li class="flex items-start">
                        <i class="fas fa-map-marker-alt mt-1 mr-3 text-primary"></i>
                        <span>123 Tax Street, Financial District, 10001</span>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-phone-alt mr-3 text-primary"></i>
                        <a href="tel:+11234567890">+1 (123) 456-7890</a>
                    </li>
                    <li class="flex items-center">
                        <i class="fas fa-envelope mr-3 text-primary"></i>
                        <a href="mailto:info@automatedtax.com">info@automatedtax.com</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="copyright">
            <p>&copy; {{ date('Y') }} {{ config('app.name', 'Automated Tax System') }}. All rights reserved.</p>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script>
    // Mobile menu toggle
    document.addEventListener('DOMContentLoaded', function() {
        const mobileMenuButton = document.querySelector('.md\\:hidden');
        const mobileMenu = document.querySelector('.mobile-menu');
        
        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
                
                // Toggle between hamburger and close icon
                const icon = this.querySelector('i');
                if (icon) {
                    if (icon.classList.contains('fa-bars')) {
                        icon.classList.remove('fa-bars');
                        icon.classList.add('fa-times');
                    } else {
                        icon.classList.remove('fa-times');
                        icon.classList.add('fa-bars');
                    }
                }
            });
        }
        
        // Close mobile menu when clicking outside
        document.addEventListener('click', function(event) {
            const isClickInside = mobileMenuButton.contains(event.target) || 
                                (mobileMenu && mobileMenu.contains(event.target));
                                
            if (!isClickInside && mobileMenu && !mobileMenu.classList.contains('hidden')) {
                mobileMenu.classList.add('hidden');
                const icon = mobileMenuButton.querySelector('i');
                if (icon) {
                    icon.classList.remove('fa-times');
                    icon.classList.add('fa-bars');
                }
            }
        });
    });
</script>
