import 'package:flutter/material.dart';

import '../core/app_constants.dart';
import '../services/contact_actions.dart';
import '../theme/app_theme.dart';
import 'contact_page.dart';
import 'get_started_page.dart';
import 'login_page.dart';

class LandingPage extends StatelessWidget {
  const LandingPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      body: Container(
        width: double.infinity,
        decoration: const BoxDecoration(
          gradient: LinearGradient(
            begin: Alignment.topLeft,
            end: Alignment.bottomRight,
            colors: [
              AppTheme.brandDark,
              AppTheme.brandGreen,
              AppTheme.brandTeal,
            ],
          ),
        ),
        child: SafeArea(
          child: SingleChildScrollView(
            padding: const EdgeInsets.fromLTRB(24, 20, 24, 28),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Row(
                  children: [
                    Container(
                      width: 44,
                      height: 44,
                      decoration: BoxDecoration(
                        color: Colors.white.withValues(alpha: 0.15),
                        borderRadius: BorderRadius.circular(12),
                      ),
                      child: const Icon(Icons.qr_code_2, color: Colors.white),
                    ),
                    const SizedBox(width: 12),
                    const Expanded(
                      child: Column(
                        crossAxisAlignment: CrossAxisAlignment.start,
                        children: [
                          Text(
                            AppConstants.appName,
                            style: TextStyle(
                              color: Colors.white,
                              fontSize: 20,
                              fontWeight: FontWeight.bold,
                            ),
                          ),
                          Text(
                            'by ${AppConstants.companyName}',
                            style: TextStyle(
                              color: Colors.white70,
                              fontSize: 12,
                              letterSpacing: 0.4,
                            ),
                          ),
                        ],
                      ),
                    ),
                    TextButton(
                      onPressed: () {
                        Navigator.of(context).push(
                          MaterialPageRoute(builder: (_) => const ContactPage()),
                        );
                      },
                      child: const Text(
                        'Contact',
                        style: TextStyle(color: Colors.white),
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 48),
                const Text(
                  'Create your CV.\nShare it with a QR code.',
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 34,
                    height: 1.2,
                    fontWeight: FontWeight.w800,
                  ),
                ),
                const SizedBox(height: 16),
                Text(
                  AppConstants.tagline,
                  style: TextStyle(
                    color: Colors.white.withValues(alpha: 0.9),
                    fontSize: 16,
                    height: 1.45,
                  ),
                ),
                const SizedBox(height: 32),
                const _FeatureCard(
                  icon: Icons.description_outlined,
                  title: 'Build a professional CV',
                  subtitle: 'Add your profile, experience, education, and skills.',
                ),
                const SizedBox(height: 12),
                const _FeatureCard(
                  icon: Icons.qr_code,
                  title: 'Generate a QR code',
                  subtitle: 'Let recruiters scan and open your CV instantly.',
                ),
                const SizedBox(height: 12),
                const _FeatureCard(
                  icon: Icons.share_outlined,
                  title: 'Share anytime',
                  subtitle: 'Keep your CV ready on your phone for interviews.',
                ),
                const SizedBox(height: 36),
                FilledButton(
                  style: FilledButton.styleFrom(
                    backgroundColor: Colors.white,
                    foregroundColor: AppTheme.brandDark,
                  ),
                  onPressed: () {
                    Navigator.of(context).push(
                      MaterialPageRoute(builder: (_) => const GetStartedPage()),
                    );
                  },
                  child: const Text('Get Started'),
                ),
                const SizedBox(height: 12),
                OutlinedButton(
                  style: OutlinedButton.styleFrom(
                    foregroundColor: Colors.white,
                    side: const BorderSide(color: Colors.white70),
                  ),
                  onPressed: () {
                    Navigator.of(context).push(
                      MaterialPageRoute(builder: (_) => const LoginPage()),
                    );
                  },
                  child: const Text('Sign in'),
                ),
                const SizedBox(height: 12),
                OutlinedButton(
                  style: OutlinedButton.styleFrom(
                    foregroundColor: Colors.white,
                    side: const BorderSide(color: Colors.white70),
                  ),
                  onPressed: () {
                    Navigator.of(context).push(
                      MaterialPageRoute(builder: (_) => const ContactPage()),
                    );
                  },
                  child: const Text('Contact MALAFYALE TECH'),
                ),
                const SizedBox(height: 28),
                Center(
                  child: Column(
                    children: [
                      Text(
                        AppConstants.phone,
                        style: const TextStyle(color: Colors.white, fontWeight: FontWeight.w600),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        AppConstants.email,
                        style: TextStyle(color: Colors.white.withValues(alpha: 0.85)),
                      ),
                      const SizedBox(height: 12),
                      Wrap(
                        spacing: 8,
                        children: [
                          TextButton.icon(
                            onPressed: () => ContactActions.callSupport(),
                            icon: const Icon(Icons.phone, color: Colors.white, size: 18),
                            label: const Text('Call', style: TextStyle(color: Colors.white)),
                          ),
                          TextButton.icon(
                            onPressed: () => ContactActions.emailSupport(),
                            icon: const Icon(Icons.email_outlined, color: Colors.white, size: 18),
                            label: const Text('Email', style: TextStyle(color: Colors.white)),
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}

class _FeatureCard extends StatelessWidget {
  const _FeatureCard({
    required this.icon,
    required this.title,
    required this.subtitle,
  });

  final IconData icon;
  final String title;
  final String subtitle;

  @override
  Widget build(BuildContext context) {
    return Container(
      width: double.infinity,
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: Colors.white.withValues(alpha: 0.12),
        borderRadius: BorderRadius.circular(16),
        border: Border.all(color: Colors.white.withValues(alpha: 0.18)),
      ),
      child: Row(
        children: [
          Icon(icon, color: Colors.white, size: 28),
          const SizedBox(width: 14),
          Expanded(
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  title,
                  style: const TextStyle(
                    color: Colors.white,
                    fontWeight: FontWeight.w700,
                    fontSize: 15,
                  ),
                ),
                const SizedBox(height: 4),
                Text(
                  subtitle,
                  style: TextStyle(
                    color: Colors.white.withValues(alpha: 0.85),
                    fontSize: 13,
                    height: 1.35,
                  ),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
