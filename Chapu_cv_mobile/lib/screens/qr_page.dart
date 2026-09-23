import 'package:flutter/material.dart';
import 'package:flutter/services.dart';
import 'package:provider/provider.dart';
import 'package:qr_flutter/qr_flutter.dart';

import '../core/app_constants.dart';
import '../services/cv_store.dart';
import '../theme/app_theme.dart';

class QrPage extends StatelessWidget {
  const QrPage({super.key});

  @override
  Widget build(BuildContext context) {
    final cv = context.watch<CvStore>().cv;
    final payload = cv.qrPayload;

    return Scaffold(
      appBar: AppBar(title: const Text('CV QR Code')),
      body: ListView(
        padding: const EdgeInsets.all(24),
        children: [
          Text(
            'Scan to share ${cv.displayName}\'s CV',
            textAlign: TextAlign.center,
            style: Theme.of(context).textTheme.titleLarge?.copyWith(
                  fontWeight: FontWeight.bold,
                  color: AppTheme.brandDark,
                ),
          ),
          const SizedBox(height: 8),
          const Text(
            'Show this QR at interviews or events. Scanning reveals your CV details.',
            textAlign: TextAlign.center,
            style: TextStyle(color: Colors.black54, height: 1.4),
          ),
          const SizedBox(height: 28),
          Center(
            child: Container(
              padding: const EdgeInsets.all(20),
              decoration: BoxDecoration(
                color: Colors.white,
                borderRadius: BorderRadius.circular(24),
                boxShadow: [
                  BoxShadow(
                    color: Colors.black.withValues(alpha: 0.06),
                    blurRadius: 24,
                    offset: const Offset(0, 8),
                  ),
                ],
              ),
              child: QrImageView(
                data: payload,
                version: QrVersions.auto,
                size: 240,
                eyeStyle: const QrEyeStyle(
                  eyeShape: QrEyeShape.square,
                  color: AppTheme.brandDark,
                ),
                dataModuleStyle: const QrDataModuleStyle(
                  dataModuleShape: QrDataModuleShape.square,
                  color: AppTheme.brandDark,
                ),
              ),
            ),
          ),
          const SizedBox(height: 24),
          Card(
            child: Padding(
              padding: const EdgeInsets.all(16),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    'QR payload preview',
                    style: TextStyle(fontWeight: FontWeight.w700),
                  ),
                  const SizedBox(height: 8),
                  Text(
                    payload,
                    style: const TextStyle(fontSize: 12, height: 1.4, color: Colors.black54),
                  ),
                ],
              ),
            ),
          ),
          const SizedBox(height: 16),
          OutlinedButton.icon(
            onPressed: () async {
              await Clipboard.setData(ClipboardData(text: payload));
              if (!context.mounted) return;
              ScaffoldMessenger.of(context).showSnackBar(
                const SnackBar(content: Text('CV text copied')),
              );
            },
            icon: const Icon(Icons.copy),
            label: const Text('Copy CV text'),
          ),
          const SizedBox(height: 20),
          const Center(
            child: Text(
              '${AppConstants.appName} · ${AppConstants.companyName}',
              style: TextStyle(fontSize: 12, color: Colors.black45),
            ),
          ),
        ],
      ),
    );
  }
}
