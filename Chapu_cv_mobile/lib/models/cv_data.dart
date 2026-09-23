class CvData {
  const CvData({
    this.fullName = '',
    this.jobTitle = '',
    this.email = '',
    this.phone = '',
    this.location = '',
    this.summary = '',
    this.experience = '',
    this.education = '',
    this.skills = '',
  });

  final String fullName;
  final String jobTitle;
  final String email;
  final String phone;
  final String location;
  final String summary;
  final String experience;
  final String education;
  final String skills;

  bool get isEmpty => fullName.trim().isEmpty;

  String get displayName => fullName.trim().isEmpty ? 'Your Name' : fullName.trim();

  String get qrPayload {
    final buffer = StringBuffer()
      ..writeln('Chapu CV — $displayName')
      ..writeln(jobTitle)
      ..writeln(email)
      ..writeln(phone)
      ..writeln(location)
      ..writeln()
      ..writeln(summary)
      ..writeln()
      ..writeln('Experience:')
      ..writeln(experience)
      ..writeln()
      ..writeln('Education:')
      ..writeln(education)
      ..writeln()
      ..writeln('Skills: $skills')
      ..writeln()
      ..writeln('Powered by MALAFYALE TECH');
    return buffer.toString().trim();
  }

  CvData copyWith({
    String? fullName,
    String? jobTitle,
    String? email,
    String? phone,
    String? location,
    String? summary,
    String? experience,
    String? education,
    String? skills,
  }) {
    return CvData(
      fullName: fullName ?? this.fullName,
      jobTitle: jobTitle ?? this.jobTitle,
      email: email ?? this.email,
      phone: phone ?? this.phone,
      location: location ?? this.location,
      summary: summary ?? this.summary,
      experience: experience ?? this.experience,
      education: education ?? this.education,
      skills: skills ?? this.skills,
    );
  }

  Map<String, String> toMap() => {
        'fullName': fullName,
        'jobTitle': jobTitle,
        'email': email,
        'phone': phone,
        'location': location,
        'summary': summary,
        'experience': experience,
        'education': education,
        'skills': skills,
      };

  factory CvData.fromMap(Map<String, dynamic> map) {
    return CvData(
      fullName: map['fullName']?.toString() ?? '',
      jobTitle: map['jobTitle']?.toString() ?? '',
      email: map['email']?.toString() ?? '',
      phone: map['phone']?.toString() ?? '',
      location: map['location']?.toString() ?? '',
      summary: map['summary']?.toString() ?? '',
      experience: map['experience']?.toString() ?? '',
      education: map['education']?.toString() ?? '',
      skills: map['skills']?.toString() ?? '',
    );
  }

  factory CvData.fromApi(Map<String, dynamic> map) {
    return CvData(
      fullName: map['full_name']?.toString() ?? '',
      jobTitle: map['job_title']?.toString() ?? '',
      email: map['email']?.toString() ?? '',
      phone: map['phone']?.toString() ?? '',
      location: map['location']?.toString() ?? '',
      summary: map['summary']?.toString() ?? '',
      experience: map['experience']?.toString() ?? '',
      education: map['education']?.toString() ?? '',
      skills: map['skills']?.toString() ?? '',
    );
  }
}
