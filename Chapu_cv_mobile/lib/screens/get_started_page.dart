import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../core/app_constants.dart';
import '../services/cv_store.dart';
import '../theme/app_theme.dart';
import 'home_page.dart';

class GetStartedPage extends StatefulWidget {
  const GetStartedPage({super.key});

  @override
  State<GetStartedPage> createState() => _GetStartedPageState();
}

class _GetStartedPageState extends State<GetStartedPage> {
  final _controller = PageController();
  int _index = 0;

  static const _steps = [
    (
      icon: Icons.edit_note_rounded,
      title: 'Fill in your details',
      body: 'Enter your name, role, experience, education, and skills in a few minutes.',
    ),
    (
      icon: Icons.preview_outlined,
      title: 'Preview your CV',
      body: 'See a clean professional layout before you share it with anyone.',
    ),
    (
      icon: Icons.qr_code_2_rounded,
      title: 'Share with QR',
      body: 'Generate a QR code so recruiters can scan and open your CV instantly.',
    ),
  ];

  @override
  void dispose() {
    _controller.dispose();
    super.dispose();
  }

  Future<void> _finish() async {
    await context.read<CvStore>().markStarted();
    if (!mounted) return;
    Navigator.of(context).pushAndRemoveUntil(
      MaterialPageRoute(builder: (_) => const HomePage()),
      (_) => false,
    );
  }

  @override
  Widget build(BuildContext context) {
    final isLast = _index == _steps.length - 1;

    return Scaffold(
      appBar: AppBar(
        title: const Text('Get Started'),
        actions: [
          TextButton(
            onPressed: _finish,
            child: const Text('Skip'),
          ),
        ],
      ),
      body: Column(
        children: [
          Expanded(
            child: PageView.builder(
              controller: _controller,
              itemCount: _steps.length,
              onPageChanged: (value) => setState(() => _index = value),
              itemBuilder: (context, index) {
                final step = _steps[index];
                return Padding(
                  padding: const EdgeInsets.symmetric(horizontal: 28),
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Container(
                        width: 110,
                        height: 110,
                        decoration: BoxDecoration(
                          color: AppTheme.brandGreen.withValues(alpha: 0.12),
                          borderRadius: BorderRadius.circular(28),
                        ),
                        child: Icon(step.icon, size: 56, color: AppTheme.brandGreen),
                      ),
                      const SizedBox(height: 32),
                      Text(
                        step.title,
                        textAlign: TextAlign.center,
                        style: Theme.of(context).textTheme.headlineSmall?.copyWith(
                              fontWeight: FontWeight.bold,
                              color: AppTheme.brandDark,
                            ),
                      ),
                      const SizedBox(height: 14),
                      Text(
                        step.body,
                        textAlign: TextAlign.center,
                        style: Theme.of(context).textTheme.bodyLarge?.copyWith(
                              color: Colors.black54,
                              height: 1.45,
                            ),
                      ),
                    ],
                  ),
                );
              },
            ),
          ),
          Row(
            mainAxisAlignment: MainAxisAlignment.center,
            children: List.generate(_steps.length, (i) {
              final active = i == _index;
              return AnimatedContainer(
                duration: const Duration(milliseconds: 200),
                margin: const EdgeInsets.symmetric(horizontal: 4),
                width: active ? 22 : 8,
                height: 8,
                decoration: BoxDecoration(
                  color: active ? AppTheme.brandGreen : Colors.black26,
                  borderRadius: BorderRadius.circular(8),
                ),
              );
            }),
          ),
          Padding(
            padding: const EdgeInsets.fromLTRB(24, 24, 24, 28),
            child: Column(
              children: [
                FilledButton(
                  onPressed: () {
                    if (isLast) {
                      _finish();
                    } else {
                      _controller.nextPage(
                        duration: const Duration(milliseconds: 280),
                        curve: Curves.easeOut,
                      );
                    }
                  },
                  child: Text(isLast ? 'Create my CV' : 'Continue'),
                ),
                const SizedBox(height: 10),
                Text(
                  'Powered by ${AppConstants.companyName}',
                  style: const TextStyle(color: Colors.black45, fontSize: 12),
                ),
              ],
            ),
          ),
        ],
      ),
    );
  }
}
