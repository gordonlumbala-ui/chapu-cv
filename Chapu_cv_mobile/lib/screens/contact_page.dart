import 'package:flutter/material.dart';

import '../core/app_constants.dart';
import '../services/contact_actions.dart';
import '../theme/app_theme.dart';

class ContactPage extends StatelessWidget {
  const ContactPage({super.key});

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Contact')),
      body: ListView(
        padding: const EdgeInsets.all(24),
        children: [
          Container(
            padding: const EdgeInsets.all(20),
            decoration: BoxDecoration(
              color: AppTheme.brandGreen,
              borderRadius: BorderRadius.circular(20),
            ),
            child: const Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  AppConstants.companyName,
                  style: TextStyle(
                    color: Colors.white,
                    fontSize: 24,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                SizedBox(height: 8),
                Text(
                  'Questions about Chapu CV? Reach our team anytime.',
                  style: TextStyle(color: Colors.white70, height: 1.4),
                ),
              ],
            ),
          ),
          const SizedBox(height: 20),
          _ContactTile(
            icon: Icons.phone_outlined,
            title: 'Phone',
            subtitle: AppConstants.phone,
            actionLabel: 'Call',
            onTap: () => ContactActions.callSupport(),
          ),
          const SizedBox(height: 12),
          _ContactTile(
            icon: Icons.email_outlined,
            title: 'Email',
            subtitle: AppConstants.email,
            actionLabel: 'Send email',
            onTap: () => ContactActions.emailSupport(),
          ),
          const SizedBox(height: 24),
          Card(
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    'About ${AppConstants.appName}',
                    style: Theme.of(context).textTheme.titleMedium?.copyWith(
                          fontWeight: FontWeight.bold,
                        ),
                  ),
                  const SizedBox(height: 8),
                  const Text(
                    'Chapu CV helps you create a professional curriculum vitae '
                    'and generate a QR code you can share at interviews, events, '
                    'and online applications.',
                    style: TextStyle(height: 1.45, color: Colors.black54),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}

class _ContactTile extends StatelessWidget {
  const _ContactTile({
    required this.icon,
    required this.title,
    required this.subtitle,
    required this.actionLabel,
    required this.onTap,
  });

  final IconData icon;
  final String title;
  final String subtitle;
  final String actionLabel;
  final VoidCallback onTap;

  @override
  Widget build(BuildContext context) {
    return Card(
      child: ListTile(
        contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 8),
        leading: CircleAvatar(
          backgroundColor: AppTheme.brandGreen.withValues(alpha: 0.12),
          foregroundColor: AppTheme.brandGreen,
          child: Icon(icon),
        ),
        title: Text(title, style: const TextStyle(fontWeight: FontWeight.w600)),
        subtitle: Text(subtitle),
        trailing: TextButton(onPressed: onTap, child: Text(actionLabel)),
      ),
    );
  }
}
