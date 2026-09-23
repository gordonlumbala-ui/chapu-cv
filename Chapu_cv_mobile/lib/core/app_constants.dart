import 'package:flutter/foundation.dart';

class AppConstants {
  static const String appName = 'Chapu CV';
  static const String companyName = 'MALAFYALE TECH';
  static const String tagline = 'Create professional CVs and share them with QR codes.';
  static const String phone = '+255782028232';
  static const String phoneTel = 'tel:+255782028232';
  static const String email = 'stuartsmg7@gmail.com';
  static const String emailMailto = 'mailto:stuartsmg7@gmail.com';
  static const String cvSharePrefix = 'chapucv://profile/';

  /// Override with --dart-define=API_BASE_URL=...
  /// Defaults: web/desktop → localhost, Android emulator → 10.0.2.2
  static String get apiBaseUrl {
    const fromEnv = String.fromEnvironment('API_BASE_URL');
    if (fromEnv.isNotEmpty) return fromEnv;
    if (kIsWeb || defaultTargetPlatform == TargetPlatform.windows) {
      return 'http://127.0.0.1:8000/api';
    }
    return 'http://10.0.2.2:8000/api';
  }
}
