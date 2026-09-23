import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../core/app_constants.dart';
import '../services/cv_store.dart';
import '../theme/app_theme.dart';
import 'qr_page.dart';

class CvPreviewPage extends StatelessWidget {
  const CvPreviewPage({super.key});

  @override
  Widget build(BuildContext context) {
    final cv = context.watch<CvStore>().cv;

    return Scaffold(
      appBar: AppBar(
        title: const Text('CV Preview'),
        actions: [
          TextButton(
            onPressed: () {
              Navigator.of(context).push(
                MaterialPageRoute(builder: (_) => const QrPage()),
              );
            },
            child: const Text('QR Code'),
          ),
        ],
      ),
      body: ListView(
        padding: const EdgeInsets.all(20),
        children: [
          Card(
            child: Padding(
              padding: const EdgeInsets.all(20),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    cv.displayName,
                    style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                          fontWeight: FontWeight.bold,
                          color: AppTheme.brandDark,
                        ),
                  ),
                  if (cv.jobTitle.isNotEmpty) ...[
                    const SizedBox(height: 4),
                    Text(
                      cv.jobTitle,
                      style: const TextStyle(
                        color: AppTheme.brandGreen,
                        fontWeight: FontWeight.w600,
                        fontSize: 16,
                      ),
                    ),
                  ],
                  const SizedBox(height: 12),
                  Wrap(
                    spacing: 12,
                    runSpacing: 6,
                    children: [
                      if (cv.email.isNotEmpty) _chip(Icons.email_outlined, cv.email),
                      if (cv.phone.isNotEmpty) _chip(Icons.phone_outlined, cv.phone),
                      if (cv.location.isNotEmpty) _chip(Icons.place_outlined, cv.location),
                    ],
                  ),
                  if (cv.summary.isNotEmpty) ...[
                    const SizedBox(height: 20),
                    _heading('Summary'),
                    Text(cv.summary, style: const TextStyle(height: 1.45)),
                  ],
                  if (cv.experience.isNotEmpty) ...[
                    const SizedBox(height: 20),
                    _heading('Experience'),
                    Text(cv.experience, style: const TextStyle(height: 1.45)),
                  ],
                  if (cv.education.isNotEmpty) ...[
                    const SizedBox(height: 20),
                    _heading('Education'),
                    Text(cv.education, style: const TextStyle(height: 1.45)),
                  ],
                  if (cv.skills.isNotEmpty) ...[
                    const SizedBox(height: 20),
                    _heading('Skills'),
                    Text(cv.skills, style: const TextStyle(height: 1.45)),
                  ],
                  const SizedBox(height: 24),
                  const Divider(),
                  const SizedBox(height: 8),
                  Text(
                    'Generated with ${AppConstants.appName} · ${AppConstants.companyName}',
                    style: const TextStyle(fontSize: 12, color: Colors.black45),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 16),
          FilledButton.icon(
            onPressed: () {
              Navigator.of(context).push(
                MaterialPageRoute(builder: (_) => const QrPage()),
              );
            },
            icon: const Icon(Icons.qr_code_2),
            label: const Text('Generate QR Code'),
          ),
        ],
      ),
    );
  }

  Widget _heading(String text) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 8),
      child: Text(
        text,
        style: const TextStyle(
          fontWeight: FontWeight.bold,
          fontSize: 15,
          color: AppTheme.brandDark,
        ),
      ),
    );
  }

  Widget _chip(IconData icon, String text) {
    return Row(
      mainAxisSize: MainAxisSize.min,
      children: [
        Icon(icon, size: 16, color: Colors.black45),
        const SizedBox(width: 4),
        Text(text, style: const TextStyle(color: Colors.black54, fontSize: 13)),
      ],
    );
  }
}
