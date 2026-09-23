import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../core/app_constants.dart';
import '../services/auth_store.dart';
import '../services/cv_store.dart';
import '../theme/app_theme.dart';
import 'contact_page.dart';
import 'create_cv_page.dart';
import 'cv_preview_page.dart';
import 'landing_page.dart';
import 'login_page.dart';
import 'qr_page.dart';

class HomePage extends StatelessWidget {
  const HomePage({super.key});

  @override
  Widget build(BuildContext context) {
    final store = context.watch<CvStore>();
    final auth = context.watch<AuthStore>();
    final cv = store.cv;
    final hasCv = !cv.isEmpty;

    return Scaffold(
      appBar: AppBar(
        title: const Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Text(AppConstants.appName),
            Text(
              AppConstants.companyName,
              style: TextStyle(fontSize: 11, color: Colors.black45, fontWeight: FontWeight.w500),
            ),
          ],
        ),
        actions: [
          if (auth.isAuthenticated)
            IconButton(
              tooltip: 'Sign out',
              onPressed: () async {
                await auth.logout();
                if (!context.mounted) return;
                Navigator.of(context).pushAndRemoveUntil(
                  MaterialPageRoute(builder: (_) => const LandingPage()),
                  (_) => false,
                );
              },
              icon: const Icon(Icons.logout),
            )
          else
            IconButton(
              tooltip: 'Sign in',
              onPressed: () {
                Navigator.of(context).push(
                  MaterialPageRoute(builder: (_) => const LoginPage()),
                );
              },
              icon: const Icon(Icons.login),
            ),
          IconButton(
            tooltip: 'Contact',
            onPressed: () {
              Navigator.of(context).push(
                MaterialPageRoute(builder: (_) => const ContactPage()),
              );
            },
            icon: const Icon(Icons.support_agent_outlined),
          ),
        ],
      ),
      body: ListView(
        padding: const EdgeInsets.all(20),
        children: [
          Container(
            padding: const EdgeInsets.all(20),
            decoration: const BoxDecoration(
              gradient: LinearGradient(
                colors: [AppTheme.brandDark, AppTheme.brandGreen],
              ),
              borderRadius: BorderRadius.all(Radius.circular(20)),
            ),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(
                  hasCv
                      ? 'Hello, ${cv.fullName.split(' ').first}'
                      : (auth.isAuthenticated
                          ? 'Hello, ${auth.name ?? 'there'}'
                          : 'Ready to build your CV?'),
                  style: const TextStyle(
                    color: Colors.white,
                    fontSize: 22,
                    fontWeight: FontWeight.bold,
                  ),
                ),
                const SizedBox(height: 8),
                Text(
                  auth.isAuthenticated
                      ? (hasCv
                          ? (cv.jobTitle.isEmpty
                              ? 'Your CV is synced with Chapu CV.'
                              : cv.jobTitle)
                          : 'Create a CV and sync it to your account.')
                      : (hasCv
                          ? 'Local draft saved. Sign in to sync to the server.'
                          : 'Create a CV, preview it, then share it with a QR code.'),
                  style: TextStyle(color: Colors.white.withValues(alpha: 0.9)),
                ),
              ],
            ),
          ),
          if (store.syncError != null) ...[
            const SizedBox(height: 12),
            Text(
              store.syncError!,
              style: const TextStyle(color: Colors.redAccent, fontSize: 13),
            ),
          ],
          const SizedBox(height: 20),
          _HomeAction(
            icon: Icons.badge_outlined,
            title: hasCv ? 'Edit CV' : 'Create CV',
            subtitle: 'Personal info, experience, education, skills',
            onTap: () {
              Navigator.of(context).push(
                MaterialPageRoute(builder: (_) => const CreateCvPage()),
              );
            },
          ),
          _HomeAction(
            icon: Icons.visibility_outlined,
            title: 'Preview CV',
            subtitle: hasCv ? 'See your professional layout' : 'Create a CV first',
            enabled: hasCv,
            onTap: () {
              Navigator.of(context).push(
                MaterialPageRoute(builder: (_) => const CvPreviewPage()),
              );
            },
          ),
          _HomeAction(
            icon: Icons.qr_code_2,
            title: 'QR Code',
            subtitle: hasCv ? 'Generate a scannable CV QR' : 'Create a CV first',
            enabled: hasCv,
            onTap: () {
              Navigator.of(context).push(
                MaterialPageRoute(builder: (_) => const QrPage()),
              );
            },
          ),
          _HomeAction(
            icon: Icons.phone_in_talk_outlined,
            title: 'Contact support',
            subtitle: '${AppConstants.phone} · ${AppConstants.email}',
            onTap: () {
              Navigator.of(context).push(
                MaterialPageRoute(builder: (_) => const ContactPage()),
              );
            },
          ),
        ],
      ),
    );
  }
}

class _HomeAction extends StatelessWidget {
  const _HomeAction({
    required this.icon,
    required this.title,
    required this.subtitle,
    required this.onTap,
    this.enabled = true,
  });

  final IconData icon;
  final String title;
  final String subtitle;
  final VoidCallback onTap;
  final bool enabled;

  @override
  Widget build(BuildContext context) {
    return Opacity(
      opacity: enabled ? 1 : 0.45,
      child: Card(
        margin: const EdgeInsets.only(bottom: 12),
        child: ListTile(
          onTap: enabled ? onTap : null,
          contentPadding: const EdgeInsets.symmetric(horizontal: 16, vertical: 10),
          leading: CircleAvatar(
            backgroundColor: AppTheme.brandGreen.withValues(alpha: 0.12),
            foregroundColor: AppTheme.brandGreen,
            child: Icon(icon),
          ),
          title: Text(title, style: const TextStyle(fontWeight: FontWeight.w700)),
          subtitle: Text(subtitle),
          trailing: const Icon(Icons.chevron_right),
        ),
      ),
    );
  }
}
